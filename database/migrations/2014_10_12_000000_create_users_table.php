<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->enum('is_admin', ['yes', 'no']);
            $table->enum('is_staff', ['yes', 'no']);
            $table->integer('media_id'); // Profile picture
            $table->text('bio');
            $table->string('language', 2); // Language code
            $table->rememberToken();
            $table->timestamps();

            // To be introduced after Media exists
            // $table->foreign('profile_pic')
            //       ->references('id')
            //       ->on('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
