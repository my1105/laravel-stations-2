<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = ['name'];

    public function sheets()
    {
        return $this->hasMany(Sheet::class);
    }
}
