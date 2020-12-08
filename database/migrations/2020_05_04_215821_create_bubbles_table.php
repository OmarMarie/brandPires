<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBubblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // bubble_type -> | 0- points | 1- gift | 2- gifts & points
        // status ->
        // 0 - not hooked
        // 1 - hooked
        Schema::create('bubbles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bubble_type');
            $table->text('bubble_content');
            $table->string('bubble_weight')->nullable();
            $table->integer('duration');
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
        Schema::dropIfExists('bubbles');
    }
}
