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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();

            $table->mediumInteger("thieving")->unsigned()->default(0);
            $table->mediumInteger("fishing")->unsigned()->default(0);
            $table->mediumInteger("mining")->unsigned()->default(0);
            $table->mediumInteger("woodcutting")->unsigned()->default(0);
            $table->mediumInteger("cooking")->unsigned()->default(0);
            $table->mediumInteger("smithing")->unsigned()->default(0);
            $table->mediumInteger("fletching")->unsigned()->default(0);
            $table->mediumInteger("crafting")->unsigned()->default(0);
            $table->mediumInteger("herblore")->unsigned()->default(0);
            $table->mediumInteger("agility")->unsigned()->default(0);
            $table->mediumInteger("farming")->unsigned()->default(0);
            $table->mediumInteger("hunter")->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
