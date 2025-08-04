<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sheet;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, $movieId, $scheduleId)
    {
        $date = $request->query('date');
        $sheetId = $request->query('sheetId');

        if (!$date || !$sheetId) {
            abort(400, '必須のパラメータが不足しています');
        }

        $exists = Reservation::where('schedule_id', $scheduleId)
            ->where('sheet_id', $sheetId)
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
        ]);

        // 重複チェック
        $exists = Reservation::where('schedule_id', $validated['schedule_id'])
            ->where('sheet_id', $validated['sheet_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['sheet_id' => 'その座席はすでに予約済みです']);
        }


        Reservation::create([
            'user_id' => Auth::id(),
            'schedule_id' => $validated['schedule_id'],
            'sheet_id' => $validated['sheet_id'],
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ]);
        return redirect()->route('reservations.index')->with('success', '予約完了');
    }
}