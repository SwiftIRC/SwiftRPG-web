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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string("name", 100)->unique();
            $table->string("description", 255)->nullable();
            $table->bigInteger("weight")->unsigned();
            $table->boolean("interactive")->default(false);
            $table->boolean("wieldable")->default(false);
            $table->boolean("throwable")->default(false);
            $table->boolean("wearable")->default(false);
            $table->boolean("consumable")->default(false);
            $table->boolean("stackable")->default(false);
            $table->smallInteger("durability")->unsigned()->default(100);
        });

        Schema::create('effects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string("name", 100);
            $table->string("description", 255)->nullable();
            $table->smallInteger("duration");
            $table->smallInteger("health_change");
            $table->smallInteger("mana_change");
            $table->smallInteger("stamina_change");
            $table->smallInteger("strength_change");
            $table->smallInteger("luck_change");
            $table->smallInteger("damage_change");
            $table->smallInteger("armor_change");
            $table->smallInteger("speed_change");
            $table->smallInteger("critical_chance")->unsigned();
            $table->smallInteger("critical_damage");
            $table->boolean("compounds");
            $table->smallInteger("compound_chance")->unsigned();
        });

        Schema::create('effect_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("item_id")->unsigned();
            $table->bigInteger("effect_id")->unsigned();

            $table->foreign("item_id")->references("id")->on("items");
            $table->foreign("effect_id")->references("id")->on("effects");
        });

        Schema::create('item_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("item_id")->unsigned();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("item_id")->references("id")->on("items");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_user');
        Schema::dropIfExists('effect_item');
        Schema::dropIfExists('effects');
        Schema::dropIfExists('items');
    }
};
