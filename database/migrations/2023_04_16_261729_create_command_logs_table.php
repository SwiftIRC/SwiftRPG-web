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
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_id')->nullable()->constrained();
            $table->string('class');
            $table->string('method');
            $table->string('verb');
            $table->string('emoji')->nullable();
            $table->smallInteger('ticks')->default(1);
            $table->boolean('log')->default(true);
        });

        Schema::create('command_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId("client_id")->constrained();
            $table->foreignId("user_id")->constrained();
            $table->foreignId('command_id')->constrained();
            $table->smallInteger('ticks')->default(1);
            $table->smallInteger('ticks_remaining')->default(1);
            $table->json('metadata')->nullable();

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
        Schema::dropIfExists('command_logs');
        Schema::dropIfExists('commands');
    }
};
