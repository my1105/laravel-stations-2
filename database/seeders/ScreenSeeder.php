<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;

class ScreenSeeder extends Seeder
{
    public function run()
    {
        Screen::insert([
            ['id' => 1, 'name' => 'スクリーン1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'スクリーン2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'スクリーン3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}