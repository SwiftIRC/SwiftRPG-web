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

            $table->unsignedSmallInteger('max_ore')->default(0);
            $table->unsignedSmallInteger('available_ore')->default(0);

            $table->timestamp('last_disturbed')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100)->unique();
            $table->string('description', 1000)->nullable();

            $table->timestamp('last_modified')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('zone_properties', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('zone_zone_property', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('zone_id')->unsigned();
            $table->bigInteger('zone_property_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000)->nullable();
            $table->bigInteger('zone_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('building_tile', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('tile_id')->unsigned();
            $table->bigInteger('building_id')->unsigned();

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
        });

        Schema::create('building_occupation', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('building_id')->unsigned();
            $table->bigInteger('occupation_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('npcs', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->enum('species', ['human', 'dwarf', 'elf']);
            $table->enum('gender', ["male", "female", "non-binary"]);
            $table->foreignId('occupation_id')->nullable()->constrained();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('building_npc', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')->constrained();
            $table->foreignId('npc_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('npc_tile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tile_id')->constrained();
            $table->foreignId('npc_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('item_npc', function (Blueprint $table) {
            $table->id();
            $table->foreignId("npc_id")->constrained();
            $table->foreignId("item_id")->constrained();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('edges', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('description', 1000)->nullable();
            $table->foreignId('terrain_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('edge_tile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('edge_id')->constrained();
            $table->foreignId('tile_id')->constrained();
            $table->enum('direction', ['north', 'east', 'south', 'west'])->default('north');
            $table->boolean('is_road')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tile_id')->default(1)->constrained();
            $table->foreignId('building_id')->nullable()->constrained();
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
        Schema::dropIfExists('zone_zone_property');
        Schema::dropIfExists('zone_properties');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('tiles');
        Schema::dropIfExists('terrains');
    }
};
