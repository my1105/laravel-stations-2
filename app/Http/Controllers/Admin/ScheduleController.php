<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        $startDate = Carbon::parse($schedule->start_time)->format('Y-m-d');
        $startTime = Carbon::parse($schedule->start_time)->format('H:i');
        $endDate = Carbon::parse($schedule->end_time)->format('Y-m-d');
        $endTime = Carbon::parse($schedule->end_time)->format('H:i');

        return view('admin.schedules.edit', compact('schedule', 'startDate', 'startTime', 'endDate', 'endTime'));
    }

public function update(Request $request, $id)
{
    $schedule = Schedule::findOrFail($id);

    $validated = $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'start_time_date' => ['required', 'date_format:Y-m-d'],
        'start_time_time' => ['required', 'date_format:H:i'],
        'end_time_date' => ['required', 'date_format:Y-m-d'],
        'end_time_time' => ['required', 'date_format:H:i'],
    ]);

    $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['start_time_date'] . ' ' . $validated['start_time_time']);
    $endTime = Carbon::createFromFormat('Y-m-d H:i', $validated['end_time_date'] . ' ' . $validated['end_time_time']);

    $schedule->start_time = $startTime;
    $schedule->end_time = $endTime;
    $schedule->save();

    return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを更新しました');
}
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを削除しました');
    }

    public function create($movieId)
    {
        $movie = Movie::findOrFail($movieId);

        return view('admin.schedules.create', compact('movie'));
    }

public function store(Request $request, $id)
{
    $validated = $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'start_time_date' => ['required', 'date_format:Y-m-d'],
        'start_time_time' => ['required', 'date_format:H:i'],
        'end_time_date' => ['required', 'date_format:Y-m-d'],
        'end_time_time' => ['required', 'date_format:H:i'],
    ]);

    if ($validated['movie_id'] != $id) {
        abort(400, 'movie_idがURLパラメータと一致しません');
    }

    $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['start_time_date'] . ' ' . $validated['start_time_time']);
    $endTime = Carbon::createFromFormat('Y-m-d H:i', $validated['end_time_date'] . ' ' . $validated['end_time_time']);

    Schedule::create([
        'movie_id' => $id,
        'start_time' => $startTime,
        'end_time' => $endTime,
    ]);

    return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを追加しました');
}

}
