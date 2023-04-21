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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->string('name');
        });

        Schema::create('skill_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedMediumInteger('quantity')->default(0);
        });

        Schema::create('npc_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained();
            $table->foreignId('npc_id')->constrained();
            $table->unsignedMediumInteger('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('npc_skill');
        Schema::dropIfExists('skill_user');
        Schema::dropIfExists('skills');
    }
};
