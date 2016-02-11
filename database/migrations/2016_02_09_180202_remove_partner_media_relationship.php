<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Partner;

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
     * Note that the data will not line up with the implementation
     * of the table if you revert this migration and you'll have
     * to change how the images are fetched for partners in
     * all the pages. Also, I
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function($table) {
	    	$table->dropColumn('featured_image');
	    	$table->integer('picture')->unsigned()->nullable();

	    	DB::raw('UPDATE partners SET picture = 1');
        	$table->foreign('picture')
                  ->references('id')
                  ->on('media');
        });
    }
}
