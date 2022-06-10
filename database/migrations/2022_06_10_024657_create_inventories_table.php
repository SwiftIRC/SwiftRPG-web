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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("gold")->unsigned();
            $table->smallInteger("size")->unsigned();

            $table->foreign("user_id")->references("id")->on("users");
        });

        Schema::create('inventory_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("inventory_id")->unsigned();
            $table->bigInteger("item_id")->unsigned();

            $table->foreign("inventory_id")->references("id")->on("inventories");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_item');
        Schema::dropIfExists('inventories');
    }
};
