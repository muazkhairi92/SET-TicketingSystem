<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

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
        $data = [
            ['id'=>1,'category'=>'Meniaga'],
            ['id'=>2,'category'=>'Adnexio'],
            ['id'=>3,'category'=>'Cista'],
        ];
        //Eloquent query 
        Category::insert($data);
    }
}

