<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Practice;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
public function run()
{
    $this->call(ScreenSeeder::class);
    $this->call(SheetSeeder::class);

}

}
