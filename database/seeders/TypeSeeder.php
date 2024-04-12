<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use Faker\Generator as Faker;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types_name = ['Frontend', 'Backend', 'Fullstack'];

        foreach ($types_name as $type_name) {
            $type = new Type();
            $type->label = $type_name;
            $type->color = $faker->hexColor();
            $type->save();
        }
    }
}
