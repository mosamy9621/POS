<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products=[[
            'name'=>'product 1',
            'description'=>'Product 1 description',
            'purchased_price'=>'12.57',
            'selling_price'=>'16.40',
            'stock'=>'150',

        ]
        ,
            [
                'name'=>'product 2',
                'description'=>'Product 2 description',
                'purchased_price'=>'11.37',
                'selling_price'=>'14.49',
                'stock'=>'200',

            ],
            [
                'name'=>'product 3',
                'description'=>'Product 3 description',
                'purchased_price'=>'17.13',
                'selling_price'=>'20.76',
                'stock'=>'263',

            ],
            [
                'name'=>'product 4',
                'description'=>'Product 4 description',
                'purchased_price'=>'19.23',
                'selling_price'=>'24.89',
                'stock'=>'233',

            ]
        ];

        $categories=['cat one','cat two' ,'cat three'];
        //generate random keys to access each category
        $categories_keys = array_rand($categories,3);

        foreach ($products as $index=> $product){
            $product_instance= new Product();
            $product_instance->fill($product);
            // adding random category to each product
            $product_instance->category()->associate($categories_keys[$index%3]+1);
            $product_instance->save();
        }
    }
}
