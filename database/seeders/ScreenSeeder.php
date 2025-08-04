<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreenSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('screens')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('screens')->insert([
            ['id' => 1, 'name' => 'スクリーン1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'スクリーン2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'スクリーン3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
