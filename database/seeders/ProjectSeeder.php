<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Project;
use App\models\Type;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // recuperiamo l'id di ogni categoria e lo assegniamo ad ogni progetto
        $types_id = Type::all()->pluck('id');

        for ($i = 0; $i < 150; $i++) {
            $project = new Project();
            $project->type_id = $faker->randomElement($types_id);
            $project->title = $faker->catchPhrase();
            $project->content = $faker->paragraphs(2, true);
            $project->slug = Str::slug($project->title);
            $project->save();
        }
    }
}
