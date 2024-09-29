<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carriers')->truncate();
        
        $carriers = [
            ['carrier_name' =>  'AIR AIRABIA', 'carrier_code' =>  "0"],
            ['carrier_name' =>  'DHL', 'carrier_code' =>  "155"],
            ['carrier_name' =>  'FLY JINNAH', 'carrier_code' =>  "514"],
            ['carrier_name' =>  'GULF AIR', 'carrier_code' =>  "072"],
            ['carrier_name' =>  'JAZEERA AIRWAYS', 'carrier_code' =>  "703"],
            ['carrier_name' =>  'PIA', 'carrier_code' =>  "214"],
            ['carrier_name' =>  'QATAR AIRWAYS', 'carrier_code' =>  "157"],
            ['carrier_name' =>  'SALAM AIR', 'carrier_code' =>  "960"],
            ['carrier_name' =>  'SAUDI AIR LINE', 'carrier_code' =>  "065"],
            ['carrier_name' =>  'SERENE AIR', 'carrier_code' =>  "092"],
        ];

        foreach ($carriers as $carrier) {
            Carrier::updateOrCreate(['carrier_code' => $carrier], [
                'carrier_name' => $carrier['carrier_name'],
                'carrier_code' => $carrier['carrier_code'],
            ]);
        }
    }
}
