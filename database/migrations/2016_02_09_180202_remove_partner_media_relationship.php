<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePartnerMediaRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	//drop the column picture, add featured image column
    	Schema::table('partners', function($table) {
        	$table->dropForeign('partners_picture_foreign');
        	$table->dropColumn('picture');
        	$table->string('featured_image')->null();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function($table) {
	    	$table->dropColumn('featured_image');
	    	$table->integer('picture')->unsigned();
        	$table->foreign('picture')
                  ->references('id')
                  ->on('media');
        });
    }
}
