<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingChargesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'country_id' => 1, 'shipping_cost' => 30000.00],
            ['id' => 2, 'country_id' => 2, 'shipping_cost' => 35000.00],
            ['id' => 3, 'country_id' => 3, 'shipping_cost' => 25000.00],
            ['id' => 4, 'country_id' => 4, 'shipping_cost' => 29000.00],
            ['id' => 5, 'country_id' => 5, 'shipping_cost' => 27000.00],
            ['id' => 6, 'country_id' => 6, 'shipping_cost' => 29000.00],
            ['id' => 7, 'country_id' => 7, 'shipping_cost' => 31000.00],
            ['id' => 8, 'country_id' => 8, 'shipping_cost' => 26000.00],
            ['id' => 9, 'country_id' => 9, 'shipping_cost' => 27000.00],
            ['id' => 10, 'country_id' => 10, 'shipping_cost' => 32000.00],
            ['id' => 11, 'country_id' => 11, 'shipping_cost' => 26000.00],
            ['id' => 12, 'country_id' => 12, 'shipping_cost' => 30000.00],
            ['id' => 13, 'country_id' => 13, 'shipping_cost' => 30000.00],
            ['id' => 14, 'country_id' => 14, 'shipping_cost' => 31000.00],
            ['id' => 15, 'country_id' => 15, 'shipping_cost' => 29000.00],
            ['id' => 16, 'country_id' => 16, 'shipping_cost' => 27000.00],
            ['id' => 17, 'country_id' => 17, 'shipping_cost' => 32000.00],
            ['id' => 18, 'country_id' => 18, 'shipping_cost' => 25000.00],
            ['id' => 19, 'country_id' => 19, 'shipping_cost' => 31000.00],
            ['id' => 20, 'country_id' => 20, 'shipping_cost' => 26000.00],
            ['id' => 21, 'country_id' => 21, 'shipping_cost' => 28000.00],
            ['id' => 22, 'country_id' => 22, 'shipping_cost' => 30000.00],
            ['id' => 23, 'country_id' => 23, 'shipping_cost' => 29000.00],
            ['id' => 24, 'country_id' => 24, 'shipping_cost' => 27000.00],
            ['id' => 25, 'country_id' => 25, 'shipping_cost' => 26000.00],
            ['id' => 26, 'country_id' => 26, 'shipping_cost' => 29000.00],
            ['id' => 27, 'country_id' => 27, 'shipping_cost' => 28000.00],
            ['id' => 28, 'country_id' => 28, 'shipping_cost' => 25000.00],
            ['id' => 29, 'country_id' => 29, 'shipping_cost' => 26000.00],
            ['id' => 30, 'country_id' => 30, 'shipping_cost' => 30000.00],
            ['id' => 31, 'country_id' => 31, 'shipping_cost' => 31000.00],
            ['id' => 32, 'country_id' => 32, 'shipping_cost' => 27000.00],
            ['id' => 33, 'country_id' => 33, 'shipping_cost' => 25000.00],
            ['id' => 34, 'country_id' => 34, 'shipping_cost' => 29000.00],
            ['id' => 35, 'country_id' => 35, 'shipping_cost' => 26000.00],
            ['id' => 36, 'country_id' => 36, 'shipping_cost' => 27000.00],
            ['id' => 37, 'country_id' => 37, 'shipping_cost' => 28000.00],
            ['id' => 38, 'country_id' => 38, 'shipping_cost' => 27000.00],
            ['id' => 39, 'country_id' => 39, 'shipping_cost' => 29000.00],
            ['id' => 40, 'country_id' => 40, 'shipping_cost' => 26000.00],
            ['id' => 41, 'country_id' => 41, 'shipping_cost' => 28000.00],
            ['id' => 42, 'country_id' => 42, 'shipping_cost' => 27000.00],
            ['id' => 43, 'country_id' => 43, 'shipping_cost' => 30000.00],
            ['id' => 44, 'country_id' => 44, 'shipping_cost' => 27000.00],
            ['id' => 45, 'country_id' => 45, 'shipping_cost' => 29000.00],
            ['id' => 46, 'country_id' => 46, 'shipping_cost' => 28000.00],
            ['id' => 47, 'country_id' => 47, 'shipping_cost' => 26000.00],
            ['id' => 48, 'country_id' => 48, 'shipping_cost' => 27000.00],
            ['id' => 49, 'country_id' => 49, 'shipping_cost' => 31000.00],
            ['id' => 50, 'country_id' => 50, 'shipping_cost' => 26000.00],
            ['id' => 51, 'country_id' => 51, 'shipping_cost' => 28000.00],
            ['id' => 52, 'country_id' => 52, 'shipping_cost' => 27000.00],
            ['id' => 53, 'country_id' => 53, 'shipping_cost' => 26000.00],
            ['id' => 54, 'country_id' => 54, 'shipping_cost' => 29000.00],
            ['id' => 55, 'country_id' => 55, 'shipping_cost' => 28000.00],
            ['id' => 56, 'country_id' => 56, 'shipping_cost' => 30000.00],
            ['id' => 57, 'country_id' => 57, 'shipping_cost' => 32000.00],
            ['id' => 58, 'country_id' => 58, 'shipping_cost' => 27000.00],
            ['id' => 59, 'country_id' => 59, 'shipping_cost' => 31000.00],
            ['id' => 60, 'country_id' => 60, 'shipping_cost' => 27000.00],
            ['id' => 61, 'country_id' => 61, 'shipping_cost' => 26000.00],
            ['id' => 62, 'country_id' => 62, 'shipping_cost' => 26000.00],
            ['id' => 63, 'country_id' => 63, 'shipping_cost' => 26000.00],
        ];

        $now = Carbon::now()->toDateTimeString();

        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('shipping_charges')->insert($data);
    }
}
