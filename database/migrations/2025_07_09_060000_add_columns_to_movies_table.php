<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('movies', function (Blueprint $table) {
        $table->integer('published_year')->nullable();
        $table->text('description')->nullable();
        $table->boolean('is_showing')->default(false);
    });
    }

    public function down()
    {
    Schema::table('movies', function (Blueprint $table) {
        $table->dropColumn(['published_year', 'description', 'is_showing']);
    });
    }

};