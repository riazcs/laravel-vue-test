<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'title' => 'Prospects 2019',
                'descr' => 'Megazine on our prospects during the year 2019. Download it and know about us to join the caravan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'title' => 'Product Catalog',
                'descr' => 'List of products with price and other details',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'title' => 'MensWear',
                'descr' => 'Shirkets, Basic t shirt, hoodies, joggers, bombers, sweatshirts, tanks, shorts and more.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Megazine: Textile Today April 2020',
                'descr' => 'It’s a comprehensive magazine for textile, apparel & fashion industry.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'title' => 'Megazine: Textile Today March 2020',
                'descr' => 'It’s a comprehensive magazine for textile, apparel & fashion industry.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
