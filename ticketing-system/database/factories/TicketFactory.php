<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title'=>\Illuminate\Support\Str::random(10),
            'description'=>\Illuminate\Support\Str::random(10),
            'categories_id'=>1,
            'priority_levels_id'=>1,
            'statuses_id'=>1,
        ];
    }
}
