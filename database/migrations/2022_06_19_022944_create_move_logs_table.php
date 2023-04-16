<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('move_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('old_tile_id');
            $table->foreignId('new_tile_id');

            $table->timestamps();

            $table->foreign('old_tile_id')->references('id')->on('tiles');
            $table->foreign('new_tile_id')->references('id')->on('tiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('move_logs');
    }
};
