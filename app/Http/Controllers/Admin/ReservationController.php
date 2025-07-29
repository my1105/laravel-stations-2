<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
public function index()
{
$reservations = Reservation::with(['schedule.movie', 'sheet'])
->whereHas('schedule', function ($query) {
$query->where('start_time', '>', now());
})
->get();

return view('admin.reservations.index', compact('reservations'));
}

public function create()
{
$schedules = Schedule::with('movie')->where('start_time', '>', now())->get();
$seats = Sheet::all();
return view('admin.reservations.create', compact('schedules', 'seats'));
}

public function store(Request $request)
{
$validated = $request->validate([
'movie_id' => 'required|exists:movies,id',
'schedule_id' => 'required|exists:schedules,id',
'sheet_id' => 'required|exists:sheets,id',
'name' => 'required|string|max:255',
'email' => 'required|email',
]);

$validated['date'] = $validated['date'] ?? now()->toDateString();

Reservation::create($validated);


$exists = Reservation::where('schedule_id', $request->schedule_id)
->where('sheet_id', $request->sheet_id)
->exists();

if ($exists) {
return redirect()->route('admin.reservations.index')->with('error', 'すでに予約されています。');
}

Reservation::create($validated);

return redirect()->route('admin.reservations.index')->with('success', '予約を追加しました。');
}

public function edit($id)
{
$reservation = Reservation::findOrFail($id);
$schedules = Schedule::with('movie')->where('start_time', '>', now())->get();
$seats = Sheet::all();
return view('admin.reservations.edit', compact('reservation', 'schedules', 'seats'));
}

public function update(Request $request, $id)
{
$reservation = Reservation::findOrFail($id);

$validated = $request->validate([
'movie_id' => 'required|exists:movies,id',
'schedule_id' => 'required|exists:schedules,id',
'sheet_id' => 'required|exists:sheets,id',
'name' => 'required|string|max:255',
'email' => 'required|email',
]);

$validated['date'] = $validated['date'] ?? now()->toDateString();

$exists = Reservation::where('schedule_id', $request->schedule_id)
->where('sheet_id', $request->sheet_id)
->where('id', '!=', $reservation->id)
->exists();

if ($exists) {
return back()->withErrors(['sheet_id' => 'この座席はすでに予約されています。'])->withInput();
}

$reservation->update($validated);

return redirect()->route('admin.reservations.index')->with('success', '予約を更新しました。');
}

public function destroy($id)
{
$reservation = Reservation::findOrFail($id);
$reservation->delete();

return redirect()->route('admin.reservations.index')->with('success', '予約を削除しました。');
}
}
