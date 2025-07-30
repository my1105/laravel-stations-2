<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sheet;
use App\Models\Schedule;
use App\Models\Reservation;
use Carbon\CarbonImmutable;

class ReservationController extends Controller
{
public function create(Request $request, $movieId, $scheduleId)
{
    $date = $request->query('date');
    $sheetId = $request->query('sheetId');

    if (!$date || !$sheetId) {
        abort(400, '必須のパラメータが不足しています');
    }


    $exists = Reservation::where('schedule_id', $request->schedule_id)
    ->where('sheet_id', $request->sheet_id)
    ->whereHas('sheet', function ($query) use ($request) {
        $query->where('screen_id', $request->screen_id);
    })
    ->exists();


    if ($exists) {
        abort(400, 'この座席はすでに予約されています');
    }

   $sheet = Sheet::findOrFail($sheetId);

return view('reservations.create', [
    'movie_id' => $movieId,
    'schedule_id' => $scheduleId,
    'sheet_id' => $sheetId,
    'sheet' => $sheet,
    'date' => $date,
]);

}

    public function store(Request $request)
    {
        $validated = $request->validate([
        'schedule_id' => 'required|integer|exists:schedules,id',
        'sheet_id' => 'required|integer|exists:sheets,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'date' => 'required|date',
    ]);

    $schedule = \App\Models\Schedule::find($validated['schedule_id']);


        $exists = Reservation::where('schedule_id', $request->schedule_id)
        ->where('sheet_id', $request->sheet_id)
        ->whereHas('sheet', function ($query) use ($request) {
            $query->where('screen_id', $request->screen_id);
        })
        ->exists();


        if ($exists) {
            return redirect()->route('sheets.index', [
                'movie' => \App\Models\Schedule::findOrFail($validated['schedule_id'])->movie_id,
                'schedule' => $validated['schedule_id'],
                'date' => $validated['date'],
            ])->with('error', 'その座席はすでに予約済みです');
        }

        \App\Models\Reservation::create([
        'schedule_id' => $validated['schedule_id'],
        'sheet_id' => $validated['sheet_id'],
        'name' => $validated['name'],
        'email' => $validated['email'],
        'date' => $validated['date'],
        'is_canceled' => false,
    ]);

         return redirect()->route('movies.show', ['id' => $schedule->movie_id])
        ->with('success', '予約が完了しました');
    }
}
