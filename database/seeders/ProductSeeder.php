<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Boné',
                'price' => 120,
                'created_at' => now()
            ],
            [
                'name' => 'Óculos de Sol',
                'price' => 67.45,
                'created_at' => now()
            ],
            [
                'name' => 'Camisa Branca',
                'price' => 55.45,
                'created_at' => now()
            ],
            [
                'name' => 'Camisa Preta',
                'price' => 78.10,
                'created_at' => now()
            ]
        ]);
    }
}
