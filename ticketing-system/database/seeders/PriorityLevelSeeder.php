<?php

namespace Database\Seeders;

use App\Models\PriorityLevel;
use Illuminate\Database\Seeder;

class PriorityLevelSeeder extends Seeder
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
            ['id'=>1,'level'=>'High'],
            ['id'=>2,'level'=>'Mid'],
            ['id'=>3,'level'=>'Low'],
        ];
        //Eloquent query 
        PriorityLevel::insert($data);
    }
}
