<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('practice', function () {
    return response('practice');
});


// GET /practice2 で変数を使って文字列 'practice2' を返す
Route::get('practice2', function() {
    $test = 'practice2';
    return response($test);
});

// GET /practice3 で文字列 'test' を返す
Route::get('practice3', function() {
    return response('test');
});