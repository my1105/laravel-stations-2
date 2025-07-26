<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->date('date')->comment('上映日');
            $table->unsignedBigInteger('schedule_id')->comment('スケジュールID');
            $table->unsignedBigInteger('sheet_id')->comment('シートID');
            $table->string('email', 255)->comment('予約者メールアドレス');
            $table->string('name', 255)->comment('予約者名');
            $table->boolean('is_canceled')->default(false)->comment('予約キャンセル済み');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('cascade');

            $table->index('schedule_id');
            $table->index('sheet_id');

            $table->unique(['schedule_id', 'sheet_id', 'date'], 'unique_schedule_sheet_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
