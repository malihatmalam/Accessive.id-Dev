<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Category;
use App\CategoryType;
use App\Place;
use App\FacilityType;
use App\Facility;
use DataTables;
use Redirect;
use Illuminate\Support\Str;
// FILE
use File;

class FilterGetData extends Controller
{
    public $successStatus = 200;
    
    // Contoh : 
    public function index()
    {
        $user = Auth::guard('api')->user();
        
        $session = BusinessSession::where('id_user', $user->id)->with('business')->first();
        if (!$session) {
          $employee = Employee::where('id_user', $user->id)->first();
          $company = Companies::where('id', $employee->id_company)->first();
          $session = BusinessSession::where('id_user', $company->id_user)->with('business')->first();
        }
        if(!$session->business){
          return response()->json(['success'=>false,'error'=>'Sesi bisnis belum dipilih.'], 400);
        }
        $session = $session->business;

        $account = Account::select('id', 'id_classification', 'account_code', 'account_name', 'position')
        ->whereHas('classification.parent', function ($query) use ($session) {
          $query->where('id_business', $session->id);
        })->get();

        return new Collection($account);

    }

    public function categoryTypeDefault()
    {

        $user = Auth::guard('api')->user();
        
        $categoryType = CategoryType::with('category')->where('is_deleted', false )->get();

        return response()->json([
            'success'=>true,
            'category_type' => $categoryType, 
        ], $this->successStatus); 
    }


    public function filterByCategoryId($category_id)
    {

        $user = Auth::guard('api')->user();

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])
        ->where('is_deleted',false)
        // ->where('category.category_id',$category_id)
        ->whereHas('category', function ($query) use ($category_id) {
            $query->where('category_id',$category_id);
        })
        ->orderBy('title_name')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

    public function filterByCategoryName($category_name)
    {

        $user = Auth::guard('api')->user();

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])
        ->where('is_deleted',false)
        ->orWhereHas('category', function ($query) use ($category_name) {
            $query->where('category_title', 'like', '%' . $category_name . '%');
        })
        ->orderBy('title_name')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

    public function searchByAll($parameter)
    {

        $user = Auth::guard('api')->user();

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])->where('is_deleted',false)
        ->where('title_name', 'like', '%' . $parameter . '%')
        ->orWhereHas('category', function ($query) use ($parameter) {
            $query->where('category_title', 'like', '%' . $parameter . '%');
        })
        // ->orWhere('category.category_title', 'like', '%' . $parameter . '%')
        ->orWhere('address', 'like', '%' . $parameter . '%')
        ->orWhere('address_gmap', 'like', '%' . $parameter . '%')
        ->orderBy('title_name')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

    public function filterByName($place_name)
    {

        $user = Auth::guard('api')->user();

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])
        ->where('is_deleted',false)
        ->where('title_name', 'like', '%' . $place_name . '%')
        ->orderBy('title_name')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

    public function filterByAddress($address_parameter)
    {

        $user = Auth::guard('api')->user();

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])->where('is_deleted',false)
        ->where('address', 'like', '%' . $address_parameter . '%')
        ->orWhere('address_gmap', 'like', '%' . $address_parameter . '%')
        ->orderBy('title_name')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

    public function filterByAll(Request $request)
    {


        $user = Auth::guard('api')->user();

        $category_array = $request->category;
        $facility_array = $request->facility;

        // return response()->json([
        //     'success'=>true,
        //     'category_array' => $category_array,
        //     'facility_array' => $facility_array, 
        // ], $this->successStatus); 

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])->where('is_deleted',false)
        // ->where('title_name', 'like', '%' . $parameter . '%')
        ->WhereHas('category', function ($query) use ($category_array) {
            $query->whereNull('category_id')->orWhereIn('category_id', $category_array);
        })
        ->orWhereHas('FacilityType', function ($query) use ($facility_array) {
            $query->whereNull('facilities.facility_type_id')->orWhereIn('facilities.facility_type_id', $facility_array);
        })
        // ->orWhere('category.category_title', 'like', '%' . $parameter . '%')
        ->orderBy('title_name')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

    public function sortDesc()
    {
        $user = Auth::guard('api')->user();

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])
        ->where('is_deleted',false)
        ->orderBy('title_name', 'desc')
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'place' => $place, 
        ], $this->successStatus); 
    }

}
