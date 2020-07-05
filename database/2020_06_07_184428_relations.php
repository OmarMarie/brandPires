<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function($table) {
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });

        Schema::table('player_bubbles', function($table) {
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('bubble_id')->references('id')->on('bubbles')->onDelete('cascade');
        });

        Schema::table('gift_actions', function($table) {
            $table->foreign('bubble_id')->references('id')->on('bubbles')->onDelete('cascade');
        });

        Schema::table('bubbles_transfer_actions', function($table) {
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });

        Schema::table('bubbles_processes', function($table) {
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });

        Schema::table('player_tank_actions', function($table) {
            $table->foreign('tank_id')->references('id')->on('tanks')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });

        Schema::table('players', function($table) {
            $table->foreign('tank_id')->references('id')->on('tanks')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('weapon_id')->references('id')->on('weapons')->onDelete('cascade');
        });

        Schema::table('friends', function($table) {
            $table->foreign('friend_id')->references('id')->on('friends')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });

        Schema::table('brands', function($table) {
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });

        Schema::table('campaigns', function($table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('bulk_id')->references('id')->on('bulks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
