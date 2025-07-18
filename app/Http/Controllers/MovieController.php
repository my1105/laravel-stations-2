<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;


class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->has('is_showing') && $request->is_showing !== '') {
            $query->where('is_showing', $request->is_showing);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $movies = $query->paginate(20)->appends($request->query());

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
