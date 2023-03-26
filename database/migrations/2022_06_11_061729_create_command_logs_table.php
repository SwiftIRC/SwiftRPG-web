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
            $table->string('class');
            $table->string('method');
            $table->smallInteger('ticks')->default(1);

            $table->timestamps();
        });

        Schema::create('command_logs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger('command_id')->unsigned();
            $table->string('message', 255);
            $table->smallInteger('ticks')->default(1);

            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign('command_id')->references('id')->on('commands');
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
