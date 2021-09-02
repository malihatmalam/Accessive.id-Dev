<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Category;
use App\Place;
use App\PlacePhoto;
use App\RecommendedPlace;
use App\Guide;
use App\GuideType;
use App\GuidePhoto;
use App\FacilityType;
use App\Facility;
use App\User;
use App\Review;
use App\UserData;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(['role:admin']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $place_count = Place::where('is_deleted', false)->get();
        $facility_count = Facility::where('is_deleted', false)->get();
        $guide_count = Guide::where('is_deleted', false)->get();
        $user_count = User::where('is_deleted', false)->where('role', 'public')->get();

        return view('admin/dashboard', compact('place_count','facility_count','guide_count','user_count' ));
        // return view('user/dashboard', compact('business', 'session', 'account', 'transaction', 'data', 'year', 'years', 'sum', 'getBusiness', 'saldo_berjalan'));
    }

    public function get_monthly_cash_flow($year = null){
        if(isset($_GET['year'])){
            $year = $_GET['year'];
        } else {
            $year = date('Y');
        }
        $user = Auth::user();
        $isCompany = $user->hasRole('company');
        if($isCompany){
            $session = session('business');
            $company = Companies::where('id_user', $user->id)->first()->id;
            $getBusiness = Business::where('id_company', $company)->first();
            if($session == 0){
                $session = $getBusiness->id;
            }
        } else {
            $getBusiness = Employee::where('id_user', $user->id)->first()->id_business;
            $session = $getBusiness;
        }
        
        $account = Account::whereHas('classification.parent', function ($q) use ($session){
            $q->where('id_business', $session);
        })->where('account_name', 'kas')
        ->first();
        
        $hmm = array();
        $cash1 = array();
        $cash2 = array();
        $position = $account->position;
        
        $monthGroup = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        foreach ($monthGroup as $month) {
            $cash_out = 0;
            $cash_in = 0;
            if(!$account->initialBalance()->whereYear('date', $year)->whereMonth('date', $month)->first()){
                $cash_in = 0;
            } else {
                $cash_in = $account->initialBalance()->whereYear('date', $year)->whereMonth('date', $month)->first()->amount;
            }
            if($account->journal()->exists()){
                $jurnals = $account->journal()->whereHas('detail', function($q) use($year, $month){
                    $q->whereYear('date', $year)->whereMonth('date', $month);
                })->get();
                
                foreach($jurnals as $jurnal){
                    if($jurnal->position == "Debit"){
                        $cash_in += $jurnal->amount;
                    } else if($jurnal->position == "Kredit"){
                        $cash_out += $jurnal->amount;
                    }
                }
            } else {
                if($account->initialBalance()->whereYear('date', $year)->first()){
                    $cash_in = $cash_in;
                } else {
                    $cash_out = 0;
                    $cash_in = 0;
                }
            }

            
            $thisMonth[] = $month;
            $cash1[] = $cash_in;
            $cash2[] = -$cash_out;

        }
        return response()->json([
            'status'=>'success',
            'bulan'=>$thisMonth,
            'in'=>$cash1,
            'out'=>$cash2,
          ]);
    }

    public function get_daily_cash_flow($date = null){
        
        if($date == null){
            $date = date('Y-m');
            $time = strtotime("now");

            $end = date("Y-m", strtotime("+1 month", $time));

            $begin = new \DateTime( $date.'-01' );
            $end = new \DateTime( $end.'-01' );
             
        } else {
            $time = strtotime($date);

            $end = date("Y-m", strtotime("+1 month", $time));

            $begin = new \DateTime( $date.'-01' );
            $end = new \DateTime( $end.'-01' );
        }

        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$end);

        $month = date("m", strtotime("first day of this month", $time));
        $year = date("Y", strtotime("first day of this month", $time));

        $user = Auth::user();
        $isCompany = $user->hasRole('company');
        if($isCompany){
            $session = session('business');
            $company = Companies::where('id_user', $user->id)->first()->id;
            $getBusiness = Business::where('id_company', $company)->first();
            if($session == 0){
                $session = $getBusiness->id;
            }
        } else {
            $getBusiness = Employee::where('id_user', $user->id)->first()->id_business;
            $session = $getBusiness;
        }
        
        $account = Account::whereHas('classification.parent', function ($q) use ($session){
            $q->where('id_business', $session);
        })->where('account_name', 'Kas')
        ->first();
        
        $position = $account->position;
        foreach ($daterange as $date) {
            $cash_out = 0;
            $cash_in = 0;
            if(!$account->initialBalance()->whereDate('date', $date)->first()){
                $cash_in = 0;
            } else {
                $cash_in = $account->initialBalance()->whereDate('date', $date)->first()->amount;
            }
            if($account->journal()->exists()){
                $jurnals = $account->journal()->whereHas('detail', function($q) use($date){
                    $q->whereDate('date', $date);
                })->get();
                
                foreach($jurnals as $jurnal){
                    if($jurnal->position == "Debit"){
                        $cash_in += $jurnal->amount;
                    } else if($jurnal->position == "Kredit"){
                        $cash_out += $jurnal->amount;
                    }
                }
            } else {
                if($account->initialBalance()->whereYear('date', $year)->first()){
                    $cash_in = $cash_in;
                } else {
                    $cash_out = 0;
                    $cash_in = 0;
                }
            }
            $day[] = $date->format("j");
            $cash1[] = $cash_in;
            $cash2[] = $cash_out;
        }
        return response()->json([
            'status'=>'success',
            'day'=>$day,
            'in'=>$cash1,
            'out'=>$cash2,
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
