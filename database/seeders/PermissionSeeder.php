<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

            'add-sport',
            'edit-sport',
            'show-sport',
            'update-sport',
            'delete-sport',
        
        ];

        foreach ($permissions as $permission) {
            $existPermission = Permission::where('name', $permission)->where('guard_name','api')->first();

            if (!$existPermission) {
                Permission::create(['guard_name'=>'api','name'=> $permission]);
            }
        }
    }
}
