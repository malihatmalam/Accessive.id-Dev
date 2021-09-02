<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserData;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
                    'email' => 'superadmin@accessive.id',
                    'role' => 'super admin',
                    'user_name' => 'superadmin',
                    'password' => Hash::make('bergandeng_bersama'),
                ]);
        $superadmin->assignRole('super admin');
        $superadminDatas = UserData::create([
            'user_id' => $superadmin->id,
            'phone' => '085747414102',
            'full_name' => 'Super Admin',
            'address' => 'Jl Mangga Super, Yogyakarta',
        ]);

        $admin = User::create([
                    'email' => 'admin@accessive.id',
                    'role' => 'admin',
                    'user_name' => 'admin',
                    'password' => Hash::make('password'),
                ]);
        $admin->assignRole('admin');
        $adminDatas = UserData::create([
            'user_id' => $admin->id,
            'phone' => '085747414102',
            'full_name' => 'Admin',
            'address' => 'Jl Jeruk Super, Yogyakarta',
        ]);
    }
}
