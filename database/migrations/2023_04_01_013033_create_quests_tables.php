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
            $table->string('name');
            $table->string('description');
            $table->string('gp')->default(0);
            $table->unsignedMediumInteger("thieving")->default(0);
            $table->unsignedMediumInteger("fishing")->default(0);
            $table->unsignedMediumInteger("mining")->default(0);
            $table->unsignedMediumInteger("woodcutting")->default(0);
            $table->unsignedMediumInteger("firemaking")->default(0);
            $table->unsignedMediumInteger("cooking")->default(0);
            $table->unsignedMediumInteger("smithing")->default(0);
            $table->unsignedMediumInteger("fletching")->default(0);
            $table->unsignedMediumInteger("crafting")->default(0);
            $table->unsignedMediumInteger("herblore")->default(0);
            $table->unsignedMediumInteger("agility")->default(0);
            $table->unsignedMediumInteger("farming")->default(0);
            $table->unsignedMediumInteger("hunter")->default(0);

            $table->timestamps();
        });

        Schema::create('quest_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quest_id');
            $table->string('output')->nullable();
            $table->unsignedSmallInteger('ticks')->default(0);

            $table->timestamps();

            $table->foreign('quest_id')->references('id')->on('quests');
        });

        Schema::create('quest_step_dependencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quest_id');
            $table->unsignedBigInteger('quest_step_id');
            $table->unsignedBigInteger('quest_step_dependency_id');

            $table->timestamps();

            $table->foreign('quest_id')->references('id')->on('quests');
            $table->foreign('quest_step_id')->references('id')->on('quest_steps');
            $table->foreign('quest_step_dependency_id')->references('id')->on('quest_steps');
        });

        Schema::create('quest_item_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quest_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedSmallInteger('quantity');

            $table->timestamps();

            $table->foreign('quest_id')->references('id')->on('quests');
            $table->foreign('item_id')->references('id')->on('items');
        });

        Schema::create('completed_quest_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quest_id');
            $table->unsignedBigInteger('quest_step_id');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('quest_id')->references('id')->on('quests');
            $table->foreign('quest_step_id')->references('id')->on('quest_steps');
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
