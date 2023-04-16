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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_id')->constrained();
            $table->string('name');
            $table->string('description');
        });

        Schema::create('quest_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quest_id')->constrained();
            $table->string('output')->nullable();
            $table->unsignedSmallInteger('ticks')->default(0);
        });

        Schema::create('quest_step_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quest_id')->constrained();
            $table->foreignId('quest_step_id')->constrained();
            $table->foreignId('quest_step_dependency_id')->constrained('quest_steps');
        });

        Schema::create('completed_quest_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('quest_id')->constrained();
            $table->foreignId('quest_step_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completed_quest_steps');
        Schema::dropIfExists('quest_item_rewards');
        Schema::dropIfExists('quest_step_dependencies');
        Schema::dropIfExists('quest_steps');
        Schema::dropIfExists('quests');
    }
};
