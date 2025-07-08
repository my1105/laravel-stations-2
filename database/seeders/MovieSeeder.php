<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Movie::create([
                'title' => $faker->sentence(3),
                'image_url' => $faker->imageUrl(300, 400, 'movies', true),
            ]);
        }
    }
}
