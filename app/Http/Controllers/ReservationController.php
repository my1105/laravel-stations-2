<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sheet;
use App\Models\Schedule;

class ReservationController extends Controller
{
    public function create(Request $request, int $movie_id, int $schedule_id)
    {
        $date = $request->query('date');
        $sheetId = $request->query('sheetId'); // クエリパラメータ名に合わせる

        if (!$date || !$sheetId) {
            abort(400, '日付または座席番号が指定されていません');
        }

        $sheet = Sheet::find($sheetId);
        if (!$sheet) {
            abort(400, '指定された座席が存在しません');
        }

        return view('reservations.create', compact('movie_id', 'schedule_id', 'date', 'sheet'));
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


        $exists = \App\Models\Reservation::where('schedule_id', $validated['schedule_id'])
            ->where('sheet_id', $validated['sheet_id'])
            ->where('date', $validated['date'])
            ->where('is_canceled', false)
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
