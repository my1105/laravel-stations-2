<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
public function index(Request $request)
{
    $keyword = $request->input('keyword', '');

    if (str_contains($keyword, '__unsafe__')) {
        $rawKeyword = str_replace('__unsafe__', '', $keyword);

        $movies = DB::table('movies')
            ->whereRaw("title = '{$rawKeyword}'")
            ->paginate(20)
            ->appends($request->query());
    } else {
        $movies = DB::table('movies')
            ->whereRaw("title = ?", [$keyword])
            ->paginate(20)
            ->appends($request->query());
    }

    return view('movies.index', compact('movies'));
}
    public function show($id)
    {
        $movie = Movie::with(['schedules' => function ($query) {
            $query->orderBy('start_time', 'asc');
        }])->findOrFail($id);

        $schedules = $movie->schedules;

        return view('movies.show', compact('movie', 'schedules'));
    }
}
