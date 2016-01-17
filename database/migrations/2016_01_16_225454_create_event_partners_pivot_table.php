<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPartnersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('partner_id');

            // To be introduced after Event and Partner exists
            // (separate migration)
            // $table->foreign('event_id')
            //       ->references('id')
            //       ->on('events');

            // $table->foreign('partner_id')
            //       ->references('id')
            //       ->on('partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_partners');
    }
}
