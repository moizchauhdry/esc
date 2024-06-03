<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(['name' => 'Admin'], ['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        Role::updateOrCreate(['name' => 'Admin']);
        Role::updateOrCreate(['name' => 'Company']);
        Role::updateOrCreate(['name' => 'Shipper']);
        Role::updateOrCreate(['name' => 'Consignee']);
        Role::updateOrCreate(['name' => 'Manager']);
        Role::updateOrCreate(['name' => 'Employee']);

        $admin = User::updateOrCreate(['email' => 'moizchauhdry@gmail.com',], [
            'name' => 'Moiz Chauhdry',
            'email' => 'moizchauhdry@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole('admin');

        $admin2 = User::updateOrCreate(['email' => 'Habib362@gmail.com',], [
            'name' => 'Habib Haseeb',
            'email' => 'Habib362@gmail.com',
            'password' => Hash::make('ESC12345'),
        ]);
        $admin2->assignRole('admin');
    }
}
