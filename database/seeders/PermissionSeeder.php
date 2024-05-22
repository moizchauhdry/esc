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

            // Basic
            'dashboard',

            // Role
            'role-list',
            'role-create',
            'role-update',

            // User
            'user-list',
            'user-create',
            'user-update',
            'user-delete',

            // Invoice
            'invoice-list',
            'invoice-create',
            'invoice-update',
            'invoice-delete',
            'invoice-print',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['name' => $permission]);
        }
    }
}
