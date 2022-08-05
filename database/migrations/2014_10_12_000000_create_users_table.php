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

            $table->unsignedBigInteger("gold")->default(0);

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
