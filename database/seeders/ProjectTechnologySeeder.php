<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projects = Project::all();

        $technologies = Technology::all()->pluck('id');

        // $project->technology()->attach([2, 3]);

        // $project->technology()->sync([2, 3]);

        foreach ($projects as $project) {
            $random_technologies = $faker->randomElements($technologies, rand(1, 3));
            $project->technology()->sync($random_technologies);
        }
    }
}
