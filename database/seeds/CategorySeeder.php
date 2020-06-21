<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories=[
           [ 'name'=>'cat one'],
            ['name'=>'cat two'] ,
            ['name'=>'cat three']
        ];
        foreach ($categories as $category)
        Category::create($category);
    }
}
