<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $technology_data = ['Javascript', 'Phyton', 'PHP', 'C'];

        foreach ($technology_data as $technology_name) {
            $technology = new Technology();
            $technology->label = $technology_name;
            $technology->color = $faker->hexColor();
            $technology->save();
        }
    }
}
