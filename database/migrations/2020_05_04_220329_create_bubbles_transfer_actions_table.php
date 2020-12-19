<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBubblesTransferActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bubbles_transfer_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_tank_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('bubbles_number');
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
        Schema::dropIfExists('bubbles_transfer_actions');
    }
}
