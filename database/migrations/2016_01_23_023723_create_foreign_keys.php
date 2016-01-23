<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->foreign('location_id')
                    ->references('id')
                    ->on('locations');
        });

        Schema::table('media', function ($table) {
            $table->foreign('event_id')
                  ->references('id')
                  ->on('events');
        });

        Schema::table('tickets', function ($table) {
            $table->foreign('event_id')
                  ->references('id')
                  ->on('events');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });

        Schema::table('event_partners', function ($table) {
            $table->foreign('event_id')
                  ->references('id')
                  ->on('events');

            $table->foreign('partner_id')
                  ->references('id')
                  ->on('partners');
        });

        Schema::table('partners', function ($table) {
            $table->foreign('location_id')
                  ->references('id')
                  ->on('locations');

            $table->foreign('picture')
                  ->references('id')
                  ->on('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('events', function ($table) {
            $table->dropForeign('events_location_id_foreign');
        });
        
        Schema::table('media', function ($table) {
            $table->dropForeign('media_event_id_foreign');
        });
        
        Schema::table('tickets', function ($table) {
            $table->dropForeign('tickets_event_id_foreign');
            $table->dropForeign('tickets_user_id_foreign');
        });
        
        Schema::table('event_partners', function ($table) {
            $table->dropForeign('event_partners_event_id_foreign');
            $table->dropForeign('event_partners_partner_id_foreign');
        });

        Schema::table('partners', function ($table) {
            $table->dropForeign('partners_location_id_foreign');
            $table->dropForeign('partners_picture_foreign');
        });
    }
}
