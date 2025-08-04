<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'schedule_id',
        'sheet_id',
        'email',
        'name',
        'is_canceled',
    ];

    protected $casts = [
        'date' => 'date',
        'is_canceled' => 'boolean',
    ];


    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }


    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // app/Models/Reservation.php
    public static function migrateUserIdFromNameEmail()
    {
        // 例: 既存の予約のnameとemailに対応するユーザを検索し user_id をセットする
        $reservations = self::whereNull('user_id')->get();

        foreach ($reservations as $reservation) {
            $user = \App\Models\User::where('name', $reservation->name)
                ->where('email', $reservation->email)
                ->first();

            if ($user) {
                $reservation->user_id = $user->id;
                $reservation->save();
            }
        }
    }


}
