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
            ['name' =>  'analytics', 'level' =>  2],

            // Role
            ['name' => 'role', 'level' => 1],
            ['name' => 'role_list', 'level' => 2],
            ['name' => 'role_create', 'level' => 2],
            ['name' => 'role_update', 'level' => 2],

            // User
            ['name' => 'user', 'level' => 1],
            ['name' => 'user_list', 'level' => 2],
            ['name' => 'user_create', 'level' => 2],
            ['name' => 'user_update', 'level' => 2],

            // Shipment
            ['name' => 'shipment', 'level' => 1],
            ['name' => 'shipment_list', 'level' => 2],
            ['name' => 'shipment_create', 'level' => 2],
            ['name' => 'shipment_update', 'level' => 2],

            // Invoices
            ['name' => 'invoice', 'level' => 1],
            ['name' => 'invoice_list', 'level' => 2],
            ['name' => 'invoice_create', 'level' => 2],
            ['name' => 'invoice_update', 'level' => 2],
            ['name' => 'invoice_print', 'level' => 2],
            ['name' => 'invoice_upload', 'level' => 2],
            ['name' => 'invoice_upload_destroy', 'level' => 2],

            // Ledger
            ['name' => 'ledger', 'level' => 1],
            ['name' => 'ledger_list', 'level' => 2],
            ['name' => 'ledger_delete', 'level' => 2],
            ['name' => 'ledger_update', 'level' => 2],
            ['name' => 'ledger_payment', 'level' => 2],
            ['name' => 'ledger_company', 'level' => 2],

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], [
                'name' => $permission['name'],
                'level' => $permission['level'],
            ]);
        }
    }
}
