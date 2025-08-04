<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;
use App\Models\Sheet;

class SheetTableSeeder extends Seeder
{
    public function run(): void
    {
        $screen = Screen::create([
            'name' => 'スクリーン1'
        ]);

        foreach (['A', 'B', 'C'] as $row) {
            for ($column = 1; $column <= 5; $column++) {
                Sheet::create([
                    'row' => $row,
                    'column' => $column,
                    'screen_id' => $screen->id,
                ]);
            }
        }
    }
}
