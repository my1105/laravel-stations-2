<?php

// app/Http/Controllers/SheetController.php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    public function index()
    {
        $sheets = Sheet::all()->groupBy('row');
        return view('sheets.index', compact('sheets'));
    }
}
