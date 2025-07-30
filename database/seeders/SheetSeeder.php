<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SheetSeeder extends Seeder
{
   public function run(): void
{
    DB::table('sheets')->insert([
        ['id' => 1, 'column' => 1, 'row' => 'a', 'screen_id' => 1],
        ['id' => 2, 'column' => 2, 'row' => 'a', 'screen_id' => 1],
        ['id' => 3, 'column' => 3, 'row' => 'a', 'screen_id' => 1],
        ['id' => 4, 'column' => 4, 'row' => 'a', 'screen_id' => 1],
        ['id' => 5, 'column' => 5, 'row' => 'a', 'screen_id' => 1],
        ['id' => 6, 'column' => 1, 'row' => 'b', 'screen_id' => 1],
        ['id' => 7, 'column' => 2, 'row' => 'b', 'screen_id' => 1],
        ['id' => 8, 'column' => 3, 'row' => 'b', 'screen_id' => 1],
        ['id' => 9, 'column' => 4, 'row' => 'b', 'screen_id' => 1],
        ['id' => 10, 'column' => 5, 'row' => 'b', 'screen_id' => 1],
        ['id' => 11, 'column' => 1, 'row' => 'c', 'screen_id' => 1],
        ['id' => 12, 'column' => 2, 'row' => 'c', 'screen_id' => 1],
        ['id' => 13, 'column' => 3, 'row' => 'c', 'screen_id' => 1],
        ['id' => 14, 'column' => 4, 'row' => 'c', 'screen_id' => 1],
        ['id' => 15, 'column' => 5, 'row' => 'c', 'screen_id' => 1],
    ]);
}

}
