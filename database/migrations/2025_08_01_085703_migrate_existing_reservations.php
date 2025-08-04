<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('reservations')->update(['user_id' => 1]); // テスト用に全てuser_id = 1で仮紐付け
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};