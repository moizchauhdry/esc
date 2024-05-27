<?php

namespace Database\Seeders;

use App\Models\InvoiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Open',
            'Draft',
            'Close',
            'Reject',
        ];

        foreach ($types as $type) {
            InvoiceStatus::updateOrCreate(['name' => $type], ['name' => $type]);
        }
    }
}
