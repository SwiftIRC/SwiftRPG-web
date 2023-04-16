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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
        });

        Schema::create('item_reward', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->bigInteger('value')->default(1);
        });

        Schema::create('reward_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_id')->constrained();
            $table->foreignId('skill_id')->constrained();
            $table->unsignedMediumInteger('value')->default(1);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward_skill');
        Schema::dropIfExists('item_reward');
        Schema::dropIfExists('rewards');
    }
};
