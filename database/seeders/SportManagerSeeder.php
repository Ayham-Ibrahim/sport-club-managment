<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SportManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Content Writer role
        $role = Role::firstOrCreate(['name' => 'SportManager','guard_name'=>'api']);

        // Define the permissions for the Content Writer role
        $permissions = [
            'add-sport',
            'edit-sport',
            'show-sport',
            'update-sport',
            'delete-sport',
        ];

        // Ensure all permissions exist in the database
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['guard_name'=>'api','name' => $permissionName]);
            $role->givePermissionTo($permission);
        }

        // Create a user with the Content Writer role
        $user = User::firstOrCreate([
            'name' => 'SportManager',
            'email' => 'SportManager@example.com',
            'password' => Hash::make('sport1234'),
            'role_name'=> 'SportManager',
        ]);

        // Assign the Content Writer role to the user
        $user->assignRole($role);
   }
}

