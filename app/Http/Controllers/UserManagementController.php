<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\User;
use App\UserData;
// use DB;
use Redirect;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
// FILE
use File;

class UserManagementController extends Controller
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
        $user = User::where('is_deleted',false)->where('role','public')->with('UserData')->orderBy('created_at', 'DESC')->get();
        return view('admin.user_management', compact('user'));
    }

    public function indexData() // Datatable Index
    {
        // $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        $user = User::where('is_deleted',false)->where('role','public')->with('UserData')->select([
            'user_id',
            'user_name',
            'account_id',
            'email',
            'role',
            'created_at',
            'updated_at',
        ]);

        return DataTables::eloquent($user)
        ->addColumn('avatar',function ($p){
            if($p->UserData->profile_photo_url){
                return '<div class="text-center">
                <img src="/user_datas/'.$p->UserData->profile_photo_url.'" width="50px" height="50px" alt="'.$p->UserData->profile_photo_url.'" style=" border-radius: 50%; vertical-align: middle;">
                </div>';
            }
            else{
                return '<div class="text-center">
                <img src="/pic/user.svg" width="50px" height="50px" alt="no picture">
                </div>';
            }
        })
        ->addColumn('action',function ($p){
            return '<td class:"text-center">
            <a class="btnEditUser btn-icon" data-toggle="modal" id="editButton" data-target="#editUserModal" 
                value="'.$p->user_id.'" class="btn btn-warning inline" >
                <i class="material-icons" style="color: #9c27b0;font-size:1.1rem;cursor: pointer;">edit</i>
                </a>
            <a class="btn-icon remove" id="'.$p->user_id.'" >
            <i class="material-icons" style="color:#f44336;font-size:1.1rem;cursor: pointer;">close</i>
            </a>
            </td>';
        })
        ->rawColumns([
            'avatar',
            'action'
        ])->toJson();
    }

    public function detailUserManagement(Request $request)
    {
        $user = User::where('user_id', $request->id)->with(['UserData'])->get();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'min:8', 'confirmed'],
            'user_name' => ['required', 'string', 'max:191', 'unique:users'],
            'full_name' => ['required', 'string', 'max:191',],
            'phone' => ['required', 'min:10', 'max:15'],
            'address' => ['required', 'string', 'max:255'],
            'profile_photo_url' => ['nullable', 'image', 'mimes:png,jpeg,jpg'],
        ],
        [
            'email.required' => 'Email tidak boleh kosong',
            'email.max' => 'Email maksimal 255 karakter',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah dipakai',
            'user_name.required' => 'Username tidak boleh kosong',
            'user_name.string' => 'Username harus berupa huruf',
            'user_name.unique' => 'Username sudah dipakai',
            'full_name.required' => 'Nama lengkap tidak boleh kosong',
            'full_name.string' => 'Nama lengkap harus berupa huruf',
            'phone.min' => 'No telp tidak boleh kurang dari 10 angka',
            'phone.max' => 'No telp tidak boleh lebih dari 15 angka',
            // 'password.min' => 'Password tidak boleh kurang dari 8 karakter',
            // 'password.required' => 'Password tidak boleh kosong',
            // 'password.confirmed' => 'Konfirmasi password tidak sama',
            'address.required' => 'Alamat tidak boleh kosong',
            'profile_photo_url.image' => 'Gambar kategori harus berupa gambar.',
            'profile_photo_url.mimes' => 'Format gambar kategori hanya berupa PNG, JPEG, dan JPG.',
        ]);
        
        $user = User::create([
            'email' => $request->email,
            'user_name' => $request->user_name,
            'password' => Hash::make('Accessive_'.$request->user_name ),
            'role' => "public",
        ]);

        $user->assignRole('public');
        $user->account_id = now()->format('Y-m-d')."-".substr(strtoupper($user->user_name),0,3)."-"."P-A"."-".str_pad($user->id, 5, '0', STR_PAD_LEFT);
        $user->save();

        $detail_user = UserData::create([
            'user_id' => $user->user_id,
            'phone'=> $request->phone,
            'full_name'=> $request->full_name,
            'address' => $request->address,
        ]);

        if ($request->hasFile('profile_photo_url')) {
            $file = $request->file('profile_photo_url');
            $filename = time() . Str::slug($request->user_name) . '.' . $file->getClientOriginalExtension();
            $file->move('user_datas', $filename);
            // File::delete('categories/' . $category->category_icon);
            
            $photo_profile = $filename;
    
            $detail_user->profile_photo_url = $photo_profile;
            $detail_user->save();

        }


        return redirect()->route('user_management.index')->with(['success' => 'Pengguna Baru Ditambahkan!']);
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
        $this->validate($request,[
            // 'edit_email' => ['required', 'string', 'email', 'max:255'],
            // 'edit_password' => [ 'min:8', 'confirmed'],
            // 'edit_user_name' => ['required', 'string', 'max:191'],
            'edit_full_name' => ['required', 'string', 'max:191',],
            'edit_phone' => ['required', 'min:10', 'max:15'],
            'edit_address' => ['required', 'string', 'max:255'],
            'edit_profile_photo_url' => ['nullable', 'image', 'mimes:png,jpeg,jpg'],
        ],
        [
            // 'edit_email.required' => 'Email tidak boleh kosong',
            // 'edit_email.max' => 'Email maksimal 255 karakter',
            // 'edit_email.email' => 'Email tidak valid',
            // // 'edit_email.unique' => 'Email sudah dipakai',
            // 'edit_user_name.required' => 'Username tidak boleh kosong',
            // 'edit_user_name.string' => 'Username harus berupa huruf',
            // // 'edit_user_name.unique' => 'Username sudah dipakai',
            'edit_full_name.required' => 'Nama lengkap tidak boleh kosong',
            'edit_full_name.string' => 'Nama lengkap harus berupa huruf',
            'edit_phone.min' => 'No telp tidak boleh kurang dari 10 angka',
            'edit_phone.max' => 'No telp tidak boleh lebih dari 15 angka',
            'edit_password.min' => 'Password tidak boleh kurang dari 8 karakter',
            'edit_password.confirmed' => 'Konfirmasi password tidak sama',
            'edit_address.required' => 'Alamat tidak boleh kosong',
            'edit_profile_photo_url.image' => 'Gambar kategori harus berupa gambar.',
            'edit_profile_photo_url.mimes' => 'Format gambar kategori hanya berupa PNG, JPEG, dan JPG.',
        ]);
        
        $user = User::find($id);

        // $user->update([
        //     'email' => $request->edit_email,
        //     'user_name' => $request->edit_user_name,
        //     'password' => Hash::make($request->edit_password ),
        //     'role' => "public",
        // ]);

        // $user->assignRole('public');
        // $user->account_id = now()->format('Y-m-d')."-".substr(strtoupper($user->user_name),0,3)."-"."P-A"."-".str_pad($user->id, 5, '0', STR_PAD_LEFT);
        // $user->save();

        $detail_user = UserData::where('user_id',$user->user_id)->first();

        $detail_user->update([
            // 'user_id' => $user->edit_user_id,
            'phone'=> $request->edit_phone,
            'full_name'=> $request->edit_full_name,
            'address' => $request->edit_address,
        ]);

        $before_photo_profile = $detail_user->profile_photo_url;

        if ($request->hasFile('edit_profile_photo_url')) {
            $file = $request->file('edit_profile_photo_url');
            $filename = time() . Str::slug($user->user_name) . '.' . $file->getClientOriginalExtension();
            $file->move('user_datas', $filename);
            
            $photo_profile = $filename;
    
            $detail_user->profile_photo_url = $photo_profile;
            $detail_user->save();
            File::delete('user_datas/' . $before_photo_profile);

        }
        return redirect()->route('user_management.index')->with(['success' => 'Pengguna Baru Telah Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->is_deleted = true;
        $user->save();

        $userData = UserData::find($user->user_id);
        $userData->is_deleted = true;
        $user->save();
        
        return response()->json([
            'status' => 'success'
        ]);

    }
}
