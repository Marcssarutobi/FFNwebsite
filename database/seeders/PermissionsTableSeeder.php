<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'role_id' => 1, // superadmin
            'route_name' => 'adminHome',
            'read' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'access_page' => true
        ]);

        Permission::create([
            'role_id' => 2, // admin
            'route_name' => 'adminHome',
            'read' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'access_page' => true
        ]);

        Permission::create([
            'role_id' => 3, // author
            'route_name' => 'adminHome',
            'read' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'access_page' => true
        ]);

        Permission::create([
            'role_id' => 4, // approver
            'route_name' => 'adminHome',
            'read' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'access_page' => true
        ]);

        Permission::create([
            'role_id' => 5, // viewer
            'route_name' => 'adminHome',
            'read' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'access_page' => true
        ]);
    }
}
