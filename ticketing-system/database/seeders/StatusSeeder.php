<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
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
            ['id'=>1,'status'=>'in-progress'],
            ['id'=>2,'status'=>'backlog'],
            ['id'=>3,'status'=>'complete'],
        ];
        //Eloquent query 
        Status::insert($data);
    
    }
}
