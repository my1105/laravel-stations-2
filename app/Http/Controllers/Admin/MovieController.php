<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.show', compact('movie'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:movies,title',
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'description' => 'required',
            'is_showing' => 'required|boolean', 
        ]);

        Movie::create([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'],
            'published_year' => $validated['published_year'],
            'is_showing' => $request->has('is_showing'),
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.movies.index')->with('success', '映画を登録しました');
    }
}
