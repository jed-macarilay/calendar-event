<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEventsDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('event_at');
            $table->unsignedBigInteger('calendar_events_id');
            $table->timestamps();
        });

        Schema::table('calendar_events_dates', function (Blueprint $table) {
            $table->foreign('calendar_events_id')->references('id')->on('calendar_events');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_events_dates');
    }
}
