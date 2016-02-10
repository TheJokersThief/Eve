<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentsSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('events', function (Blueprint $table) {
		    $table->decimal('price', 6,2)->unsigned();
	    });
	    Schema::table('tickets', function (Blueprint $table) {
		    $table->decimal('price', 6,2)->unsigned();
		    $table->string('charge_id')->nullable();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('events', function (Blueprint $table) {
		    $table->dropColumn('price');
	    });
	    Schema::table('tickets', function (Blueprint $table) {
		    $table->dropColumn(['price','charge_id']);
	    });
    }
}
