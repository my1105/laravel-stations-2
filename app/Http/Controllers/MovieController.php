<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all(); // 全ての映画データを取得
        return view('movies.index', ['movies' => $movies]);
    }
}