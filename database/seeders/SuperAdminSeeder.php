<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 'employee' role with 'api' guard
        $role1 = Role::create([
            "name" => "employee",
            "guard_name" => 'api'
        ]);

        // Create 'Admin' role with 'api' guard
        $role = Role::create([
            "name" => "Admin",
            "guard_name" => "api"
        ]);

        // Get all permissions
        $permissions = Permission::pluck("id",'id')->all();

        // Sync permissions with the 'Admin' role
        $role->syncPermissions($permissions);

        // Create an admin user
        $user = User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make('admin1234'),
            "role_name" => 'Admin',
        ]);

        // Explicitly use the 'api' guard when assigning the role
        $user->assignRole('Admin');   
     }

}
