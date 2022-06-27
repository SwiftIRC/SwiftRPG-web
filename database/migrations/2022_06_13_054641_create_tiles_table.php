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
        Schema::create("terrains", function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 1000)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("discovered_by")->nullable();
            $table->unsignedBigInteger("terrain_id");

            $table->string("psuedo_id", 100)->unique();
            $table->bigInteger("x");
            $table->bigInteger("y");

            $table->unsignedSmallInteger("max_trees")->default(0);
            $table->unsignedSmallInteger("available_trees")->default(0);

            $table->timestamp('last_disturbed')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("discovered_by")->references("id")->on("users");
            $table->foreign("terrain_id")->references("id")->on("terrains");
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100)->unique();
            $table->string("description", 1000)->nullable();

            $table->boolean('is_shop')->default(false);
            $table->boolean('is_pub')->default(false);
            $table->boolean('is_house')->default(false);
            $table->boolean('is_accessible')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_bed')->default(false);
            $table->boolean('is_pilferable')->default(false);
            $table->timestamp('last_pilfered')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 1000)->nullable();
            $table->bigInteger("zone_id")->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("zone_id")->references("id")->on("zones");
        });

        Schema::create('building_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("tile_id")->unsigned();
            $table->bigInteger("building_id")->unsigned();

            $table->foreign("tile_id")->references("id")->on("tiles");
            $table->foreign("building_id")->references("id")->on("buildings");

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('occupations', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 1000)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('npcs', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 1000)->nullable();
            $table->bigInteger("occupation_id")->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('building_npc', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("building_id")->unsigned();
            $table->bigInteger("npc_id")->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("building_id")->references("id")->on("buildings");
            $table->foreign("npc_id")->references("id")->on("npcs");
        });

        Schema::create('npc_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("tile_id")->unsigned();
            $table->bigInteger("npc_id")->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("tile_id")->references("id")->on("tiles");
            $table->foreign("npc_id")->references("id")->on("npcs");
        });

        Schema::create('edges', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 1000)->nullable();
            $table->unsignedBigInteger("terrain_id");

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("terrain_id")->references("id")->on("terrains");
        });

        Schema::create('edge_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("edge_id")->unsigned();
            $table->bigInteger("tile_id")->unsigned();
            $table->enum('direction', ['north', 'east', 'south', 'west'])->default('north');
            $table->boolean("is_road")->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("tile_id")->references("id")->on("tiles");
            $table->foreign("edge_id")->references("id")->on("edges");
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('tile_id')->unsigned()->default(1);
            $table->bigInteger('building_id')->unsigned()->nullable();

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
            $table->dropForeign(['tile_id']);
            $table->dropColumn('building_id');
            $table->dropColumn('tile_id');
        });
        Schema::dropIfExists('edge_tile');
        Schema::dropIfExists('edges');
        Schema::dropIfExists('npc_tile');
        Schema::dropIfExists('building_npc');
        Schema::dropIfExists('occupations');
        Schema::dropIfExists('npcs');
        Schema::dropIfExists('building_tile');
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('tiles');
        Schema::dropIfExists('terrains');
    }
};
