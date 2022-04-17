<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ["email"=>"admin"],
            [
                "name"=>"Administrador",
                "password"=>Hash::make("admin"),
                "role_id"=>1
            ]
        );

        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );
        
        User::updateOrCreate(
            ["email"=>"user"],
            [
                "name"=>"Usuario Prueba",
                "password"=>Hash::make("user"),
                "role_id"=>2
            ]
        );

    }
}
