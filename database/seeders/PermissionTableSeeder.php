<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',           
            'city-list',
            'city-create',
            'city-edit',
            'city-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete'


            ];
            foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            }
            
    }
}