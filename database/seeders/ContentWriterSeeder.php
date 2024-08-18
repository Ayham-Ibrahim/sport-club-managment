<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContentWriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create the Content Writer role
         $role = Role::firstOrCreate(['name' => 'ContentWriter','guard_name'=>'api']);

         // Define the permissions for the Content Writer role
         $permissions = [
             'add-category',
             'edit-category',
             'show-category',
             'update-category',
             'delete-category',
 
             'add-article',
             'edit-article',
             'show-article',
             'update-article',
             'delete-article',
         ];
 
         // Ensure all permissions exist in the database
         foreach ($permissions as $permissionName) {
             $permission = Permission::firstOrCreate(['guard_name'=>'api','name' => $permissionName]);
             $role->givePermissionTo($permission);
         }
 
         // Create a user with the Content Writer role
         $user = User::firstOrCreate([
             'name' => 'Writer',
             'email' => 'writer@example.com',
             'password' => Hash::make('writer1234'),
             'role_name'=> 'ContentWriter',
         ]);
 
         // Assign the Content Writer role to the user
         $user->assignRole($role);
    }
}
