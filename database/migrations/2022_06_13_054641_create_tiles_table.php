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
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000)->nullable();
            $table->smallInteger('movement_cost')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('discovered_by')->nullable();
            $table->timestamp('discovered_at')->nullable();
            $table->unsignedBigInteger('terrain_id');

            $table->string('psuedo_id', 100)->unique();
            $table->bigInteger('x');
            $table->bigInteger('y');

            $table->unsignedSmallInteger('max_trees')->default(0);
            $table->unsignedSmallInteger('available_trees')->default(0);

            $table->timestamp('last_disturbed')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('discovered_by')->references('id')->on('users');
            $table->foreign('terrain_id')->references('id')->on('terrains');
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100)->unique();
            $table->string('description', 1000)->nullable();

            $table->timestamp('last_modified')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('zoneproperties', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('zone_zoneproperty', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('zone_id')->unsigned();
            $table->bigInteger('zoneproperty_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('zoneproperty_id')->references('id')->on('zoneproperties');
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000)->nullable();
            $table->bigInteger('zone_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_id')->references('id')->on('zones');
        });

        Schema::create('building_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('tile_id')->unsigned();
            $table->bigInteger('building_id')->unsigned();

            $table->foreign('tile_id')->references('id')->on('tiles');
            $table->foreign('building_id')->references('id')->on('buildings');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('occupations', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('occupation_zone', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('zone_id')->unsigned();
            $table->bigInteger('occupation_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('occupation_id')->references('id')->on('occupations');
        });

        Schema::create('building_occupation', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('building_id')->unsigned();
            $table->bigInteger('occupation_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('building_id')->references('id')->on('buildings');
            $table->foreign('occupation_id')->references('id')->on('occupations');
        });

        Schema::create('npcs', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->enum('species', ['human', 'dwarf', 'elf']);
            $table->enum('gender', ["male", "female", "non-binary"]);
            $table->bigInteger('occupation_id')->unsigned()->nullable();

            $table->unsignedMediumInteger('thieving')->default(0);
            $table->unsignedMediumInteger('fishing')->default(0);
            $table->unsignedMediumInteger('mining')->default(0);
            $table->unsignedMediumInteger('woodcutting')->default(0);
            $table->unsignedMediumInteger('firemaking')->default(0);
            $table->unsignedMediumInteger('cooking')->default(0);
            $table->unsignedMediumInteger('smithing')->default(0);
            $table->unsignedMediumInteger('fletching')->default(0);
            $table->unsignedMediumInteger('crafting')->default(0);
            $table->unsignedMediumInteger('herblore')->default(0);
            $table->unsignedMediumInteger('agility')->default(0);
            $table->unsignedMediumInteger('farming')->default(0);
            $table->unsignedMediumInteger('hunter')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('occupation_id')->references('id')->on('occupations');
        });

        Schema::create('building_npc', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('building_id')->unsigned();
            $table->bigInteger('npc_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('building_id')->references('id')->on('buildings');
            $table->foreign('npc_id')->references('id')->on('npcs');
        });

        Schema::create('npc_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('tile_id')->unsigned();
            $table->bigInteger('npc_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tile_id')->references('id')->on('tiles');
            $table->foreign('npc_id')->references('id')->on('npcs');
        });

        Schema::create('item_npc', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("npc_id")->unsigned();
            $table->bigInteger("item_id")->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("npc_id")->references("id")->on("npcs");
            $table->foreign("item_id")->references("id")->on("items");
        });

        Schema::create('edges', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000)->nullable();
            $table->unsignedBigInteger('terrain_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('terrain_id')->references('id')->on('terrains');
        });

        Schema::create('edge_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('edge_id')->unsigned();
            $table->bigInteger('tile_id')->unsigned();
            $table->enum('direction', ['north', 'east', 'south', 'west'])->default('north');
            $table->boolean('is_road')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tile_id')->references('id')->on('tiles');
            $table->foreign('edge_id')->references('id')->on('edges');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('tile_id')->unsigned()->default(1);
            $table->unsignedBigInteger('building_id')->unsigned()->nullable();

            $table->foreign('tile_id')->references('id')->on('tiles');
            $table->foreign('building_id')->references('id')->on('buildings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_building_id_foreign');
            $table->dropForeign('users_tile_id_foreign');
            $table->dropColumn('building_id');
            $table->dropColumn('tile_id');
        });
        Schema::dropIfExists('edge_tile');
        Schema::dropIfExists('edges');
        Schema::dropIfExists('item_npc');
        Schema::dropIfExists('npc_tile');
        Schema::dropIfExists('building_npc');
        Schema::dropIfExists('building_occupation');
        Schema::dropIfExists('npcs');
        Schema::dropIfExists('occupation_zone');
        Schema::dropIfExists('occupations');
        Schema::dropIfExists('building_tile');
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('zone_zoneproperty');
        Schema::dropIfExists('zoneproperties');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('tiles');
        Schema::dropIfExists('terrains');
    }
};
