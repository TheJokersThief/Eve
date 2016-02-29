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
        // Create the events table
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->string('featured_image');
            $table->integer('location_id')->unsigned();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('title');
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
        // Drop the events table
        Schema::drop('events');
    }
}
