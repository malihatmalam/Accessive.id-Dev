<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DB;
use App\User;
use App\UserData;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'user_name' => ['required', 'string', 'max:191', 'unique:users'],
            'full_name' => ['required', 'string', 'max:191',],
            'phone' => ['required', 'min:10', 'max:15'],
            'address' => ['required', 'string', 'max:255'],
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
            'password.min' => 'Password tidak boleh kurang dari 8 karakter',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'address.required' => 'Alamat tidak boleh kosong',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'user_name' => $data['user_name'],
            'password' => Hash::make($data['password']),
            'role' => "admin",
        ]);

        $user->assignRole('admin');

        $detail_user = UserData::create([
            'user_id' => $user->user_id,
            'phone'=> $data['phone'],
            'full_name'=> $data['full_name'],
            'address' => $data['address'],
        ]);

        return $user;
    }
}
