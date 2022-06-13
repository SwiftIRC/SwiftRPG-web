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
        Schema::create('tiles', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("discovered_by")->unsigned()->nullable();

            $table->string("psuedo_id", 100)->unique();
            $table->bigInteger("x");
            $table->bigInteger("y");

            $table->smallInteger("max_trees")->unsigned()->default(0);
            $table->smallInteger("available_trees")->unsigned()->default(0);

            $table->smallInteger("north_edge")->unsigned();
            $table->smallInteger("east_edge")->unsigned();
            $table->smallInteger("south_edge")->unsigned();
            $table->smallInteger("west_edge")->unsigned();

            $table->timestamp('last_disturbed')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("discovered_by")->references("id")->on("users");
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100)->unique();
            $table->string("description", 255)->nullable();

            $table->boolean('is_shop')->default(false);
            $table->boolean('is_pub')->default(false);
            $table->boolean('is_house')->default(false);
            $table->boolean('is_accessible')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_bed')->default(false);
            $table->boolean('is_pilferable')->default(false);
            $table->boolean('is_pilfered')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 255)->nullable();
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

        Schema::create('npcs', function (Blueprint $table) {
            $table->id();

            $table->string("name", 100);
            $table->string("description", 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('building_npc', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("building_id")->unsigned();
            $table->bigInteger("npc_id")->unsigned();

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
            $table->string("description", 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('edge_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("edge_id")->unsigned();
            $table->bigInteger("tile_id")->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("tile_id")->references("id")->on("tiles");
            $table->foreign("edge_id")->references("id")->on("edges");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edge_tile');
        Schema::dropIfExists('edges');
        Schema::dropIfExists('npc_tile');
        Schema::dropIfExists('building_npc');
        Schema::dropIfExists('npcs');
        Schema::dropIfExists('building_tile');
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('tiles');
    }
};
