<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
		    $table->integer('user_id')->unsigned();

		    // Update existing columns to belong to the very first user
		    // to avoid constraint failure on foreign key setup
		    DB::raw('UPDATE media SET user_id = 1');

		    $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
        	$table->dropForeign('media_user_id_foreign');
		    $table->dropColumn('user_id');
	    });
    }
}
