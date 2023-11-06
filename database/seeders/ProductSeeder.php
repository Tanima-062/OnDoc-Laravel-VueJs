<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create([
            'company_id' => 1,
            'status'     => Product::ACTIVE
        ])->each(function ($item) {
            Document::factory()->count(mt_rand(5, 30))->create([
                'product_id'    =>  $item->id
            ]);
        });

        Product::factory()->count(100)->create()
            ->each(function ($item) {
                Document::factory()->count(mt_rand(5, 30))->create([
                    'product_id'    =>  $item->id
                ]);
            });
    }
}
