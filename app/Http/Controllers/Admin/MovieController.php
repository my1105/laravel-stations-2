<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
public function index()
{
    $movies = Movie::with('genre')->get(); 
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
        'genre' => 'required|string'
    ]);

    DB::transaction(function () use ($validated) {
        $genre = Genre::firstOrCreate(['name' => $validated['genre']]);

        Movie::create([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'],
            'published_year' => $validated['published_year'],
            'description' => $validated['description'],
            'is_showing' => $validated['is_showing'],
            'genre_id' => $genre->id,
        ]);
    });

    return redirect()->route('admin.movies.index');
}


public function update(Request $request, $id)
{
    $movie = Movie::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|unique:movies,title,' . $movie->id,
        'image_url' => 'required|url',
        'published_year' => 'required|integer',
        'description' => 'required',
        'is_showing' => 'required|boolean',
        'genre' => 'required|string',
    ]);

    DB::transaction(function () use ($validated, $movie) {
        $genre = Genre::firstOrCreate(['name' => $validated['genre']]);

        $movie->update([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'],
            'published_year' => $validated['published_year'],
            'description' => $validated['description'],
            'is_showing' => $validated['is_showing'],
            'genre_id' => $genre->id,
        ]);
    });

    return redirect()->route('admin.movies.index')->with('success', '映画情報を更新しました');
}


public function edit($id)
{
    $movie = Movie::with('genre')->findOrFail($id);
    return view('admin.movies.edit', compact('movie'));
}



public function destroy($id)
{
    $movie = Movie::findOrFail($id);
    $movie->delete();

    return redirect()->route('admin.movies.index')->with('success', '映画を削除しました');
}

private function validateMovie(Request $request, ?int $id = null)
{
    $ruleUnique = 'unique:movies,title';
    if ($id) {
        $ruleUnique .= ',' . $id;
    }

    return $request->validate([
        'title' => ['required', $ruleUnique],
        'image_url' => ['required', 'url'],
        'published_year' => ['required', 'integer'],
        'description' => ['required'],
        'is_showing' => ['required', 'boolean'],
    ]);
}

}
