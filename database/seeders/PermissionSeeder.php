<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // Dashboard
            ['name' =>  'dashboard', 'level' =>  1],

            // Role
            ['name' => 'role', 'level' => 1],
            ['name' => 'role-list', 'level' => 2],
            ['name' => 'role-create', 'level' => 2],
            ['name' => 'role-update', 'level' => 2],

            // User
            ['name' => 'user', 'level' => 1],
            ['name' => 'user-list', 'level' => 2],
            ['name' => 'user-create', 'level' => 2],
            ['name' => 'user-update', 'level' => 2],

            // Shipment
            ['name' => 'shipment', 'level' => 1],
            ['name' => 'shipment-list', 'level' => 2],
            ['name' => 'shipment-create', 'level' => 2],
            ['name' => 'shipment-update', 'level' => 2],

            // Invoices
            ['name' => 'invoice', 'level' => 1],
            ['name' => 'invoice-list', 'level' => 2],
            ['name' => 'invoice-update', 'level' => 2],
            ['name' => 'invoice-print', 'level' => 2]

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], [
                'name' => $permission['name'],
                'level' => $permission['level'],
            ]);
        }
    }
}
