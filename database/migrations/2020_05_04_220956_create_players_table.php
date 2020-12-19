<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('type')->nullable();
            $table->string('phone_number');
            $table->date('birth_day');
            $table->string('img');
            $table->string('lvl_pts')->nullable();
            $table->string('tank_pts')->nullable();
            $table->boolean('verify_code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->integer('tank_id')->unsigned()->nullable();
            $table->integer('level_id')->unsigned()->nullable();
            $table->string('bullets')->nullable();
            $table->integer('weapon_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
