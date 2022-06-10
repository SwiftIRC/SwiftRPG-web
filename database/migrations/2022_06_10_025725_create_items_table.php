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
            $table->bigInteger("user_id")->unsigned();
            $table->string("name", 100);
            $table->string("description", 255)->nullable();
            $table->bigInteger("weight")->unsigned();
            $table->boolean("interactive");
            $table->boolean("wieldable");
            $table->boolean("throwable");
            $table->boolean("wearable");
            $table->boolean("consumable");
            $table->smallInteger("durability")->unsigned();

            $table->foreign("user_id")->references("id")->on("users");
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

        Schema::create('item_effects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("item_id")->unsigned();
            $table->bigInteger("effect_id")->unsigned();

            $table->foreign("item_id")->references("id")->on("items");
            $table->foreign("effect_id")->references("id")->on("effects");
        });

        Schema::table('inventory_items', function (Blueprint $table) {
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
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropForeign("inventory_items_item_id_foreign");
        });

        Schema::dropIfExists('item_effects');
        Schema::dropIfExists('effects');
        Schema::dropIfExists('items');
    }
};
