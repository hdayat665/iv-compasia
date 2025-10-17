<?php

namespace Database\Seeders;

use App\Models\ProductMasterList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMasterListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
        ["4450", "Smartphone", "Apple", "iPhone SE", "2GB/16GB", 13],
        ["4768", "Smartphone", "Apple", "iPhone SE", "2GB/32GB", 30],
        ["4451", "Smartphone", "Apple", "iPhone SE", "2GB/64GB", 20],
        ["4574", "Smartphone", "Apple", "iPhone SE", "2GB/128GB", 16],
        ["6039", "Smartphone", "Apple", "iPhone SE (2020)", "3GB/64GB", 18],
    ];

    foreach ($products as $p) {
        ProductMasterList::updateOrCreate(
            ['product_id' => $p[0]],
            [
                'types'    => $p[1],
                'brand'    => $p[2],
                'model'    => $p[3],
                'capacity' => $p[4],
                'quantity' => $p[5],
            ]
        );
    }
    }
}
