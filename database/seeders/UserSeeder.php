<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_list = Permission::create(['name' => 'users.listerr']);
        $user_view = Permission::create(['name' => 'users.voir']);
        $user_create = Permission::create(['name' => 'users.creation']);
        $user_update = Permission::create(['name' => 'users.modification']);
        $user_delete = Permission::create(['name' => 'users.supprimer']);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo([
            $user_list,
            $user_view,
            $user_create,
            $user_update,
            $user_delete
    ]);
        $admin = User::create([
            'name'=> 'Admin',
            'email'=> 'admin@admin.com',
            'password'=> bcrypt('password')
    ]);
      $admin->assignRole($admin_role);
      $admin_role->givePermissionTo([
            $user_list,
            $user_view,
            $user_create,
            $user_update,
            $user_delete
    ]);

    $user = User::create([
            'name'=> 'user',
            'email'=> 'user@user.com',
            'password'=> bcrypt('password')
    ]);

      $user_role = Role::create(['name' => 'user']);
      $user->assignRole($user_role);
      $user->givePermissionTo([
            $user_list,
           
    ]);

    }
}
