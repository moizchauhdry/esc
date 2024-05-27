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

        $employee = User::updateOrCreate(['email' => 'employee@gmail.com',], [
            'name' => 'Employee',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $employee->assignRole('employee');

        $manager = User::updateOrCreate(['email' => 'manager@gmail.com',], [
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $manager->assignRole('manager');

        $company = User::updateOrCreate(['email' => 'company@gmail.com',], [
            'name' => 'Company',
            'email' => 'company@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $company->assignRole('company');

        $shipper = User::updateOrCreate(['email' => 'shipper@gmail.com',], [
            'name' => 'shipper',
            'email' => 'shipper@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $shipper->assignRole('shipper');

        $shipper2 = User::updateOrCreate(['email' => 'shipper2@gmail.com',], [
            'name' => 'shipper2',
            'email' => 'shipper2@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $shipper2->assignRole('shipper');

        $consignee = User::updateOrCreate(['email' => 'consignee@gmail.com',], [
            'name' => 'consignee',
            'email' => 'consignee@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $consignee->assignRole('consignee');


        $consignee2 = User::updateOrCreate(['email' => 'consignee2@gmail.com',], [
            'name' => 'consignee2',
            'email' => 'consignee2@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $consignee2->assignRole('consignee');
    }
}
