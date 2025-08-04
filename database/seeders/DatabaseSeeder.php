<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Practice;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
public function run()
{

     DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    DB::table('sheets')->truncate();

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    $this->call(ScreenSeeder::class);
    $this->call(SheetTableSeeder::class);


}

}
