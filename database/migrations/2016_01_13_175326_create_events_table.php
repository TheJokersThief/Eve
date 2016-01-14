<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->integer('location_id');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('title');
            $table->timestamps();

            $table->foreign('location_id')
                    ->references('id')
                    ->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
