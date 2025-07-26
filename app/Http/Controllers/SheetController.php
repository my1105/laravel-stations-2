<?php


namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{


public function index(int $movie, int $schedule, Request $request)
{
    $date = $request->query('date');

    if (!$date) {
        abort(400, '日付が指定されていません');
    }

    $sheets = Sheet::all();

    return view('sheets.index', [
        'movie_id' => $movie,
        'schedule_id' => $schedule,
        'date' => $date,
        'sheets' => $sheets,
    ]);
}

 public function indexSimple()
    {
        $sheets = Sheet::all();

        return view('sheets.index', [
            'sheets' => $sheets,
        ]);
    }


}
