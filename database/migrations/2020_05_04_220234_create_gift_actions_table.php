<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // action -> | 0 - expired | 1 - active | 2 - replaced
        // status -> | 0 - unseen | 1 - seen
        Schema::create('gift_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->string('time');
            $table->integer('bubble_id')->unsigned();
            $table->integer('player_id')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->string('gift_content');
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
        Schema::dropIfExists('gift_actions');
    }
}
