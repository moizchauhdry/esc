<?php

namespace Database\Seeders;

use App\Models\InvoiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Initial',
            'Final',
        ];

        foreach ($types as $type) {
            InvoiceType::updateOrCreate(['name' => $type], ['name' => $type]);
        }
    }
}
