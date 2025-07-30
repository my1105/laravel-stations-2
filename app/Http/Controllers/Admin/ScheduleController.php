<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;
use Carbon\Carbon;
use App\Models\Screen;

class ScheduleController extends Controller
{
    public function index()
    {
        $movies = Movie::whereHas('schedules')
            ->with(['schedules'])
            ->get();

        return view('admin.schedules.index', compact('movies'));
    }

    public function show($id)
    {
        $schedule = Schedule::with('movie')->findOrFail($id);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit($id)
    {
        $schedule = Schedule::with('movie')->findOrFail($id);
        $screens = Screen::all();
        $startDate = Carbon::parse($schedule->start_time)->format('Y-m-d');
        $startTime = Carbon::parse($schedule->start_time)->format('H:i');
        $endDate = Carbon::parse($schedule->end_time)->format('Y-m-d');
        $endTime = Carbon::parse($schedule->end_time)->format('H:i');

        return view('admin.schedules.edit', compact('schedule', 'screens', 'startDate', 'startTime', 'endDate', 'endTime'));
    }
    public function update(ScheduleRequest $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $validated = $request->validated();

        $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['start_time_date'] . ' ' . $validated['start_time_time']);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $validated['end_time_date'] . ' ' . $validated['end_time_time']);

$screenId = $validated['screen_id'] ?? \App\Models\Screen::first()->id;

$schedule->update([
    'movie_id'   => $validated['movie_id'],
    'screen_id'  => $screenId,
    'start_time' => $startTime,
    'end_time'   => $endTime,
]);

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを更新しました');
    }

    public function create($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $screens = Screen::all();
        return view('admin.schedules.create', compact('movie', 'screens'));
    }

   public function store(ScheduleRequest $request, $id)
{
    $validated = $request->validated();

    if ($validated['movie_id'] != $id) {
        abort(400, 'movie_idがURLパラメータと一致しません');
    }

    $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['start_time_date'] . ' ' . $validated['start_time_time']);
    $endTime = Carbon::createFromFormat('Y-m-d H:i', $validated['end_time_date'] . ' ' . $validated['end_time_time']);

    $screenId = $validated['screen_id'] ?? \App\Models\Screen::first()->id;

    Schedule::create([
        'movie_id' => $id,
        'screen_id' => $screenId,
        'start_time' => $startTime,
        'end_time' => $endTime,
    ]);

    return redirect()->route('admin.movies.show', $id);
}

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを削除しました');
    }
}