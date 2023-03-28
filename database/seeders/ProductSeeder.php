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
                'title' => 'Lorem ipsum, dolor sit amet',
                'descr' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Inventore consequatur hic nesciunt ipsa excepturi magnam unde magni quae pariatur nihil ex delectus voluptatibus, exercitationem doloremque iste autem dolorum, distinctio dolores?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'title' => 'lorem test',
                'descr' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio repellat culpa neque dicta doloribus alias ad consequuntur harum ipsam animi, sed dolorem earum, rerum voluptas natus accusamus quia deserunt et!",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
