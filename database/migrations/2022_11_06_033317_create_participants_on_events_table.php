<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsOnEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_on_events', function (Blueprint $table) 
        {
            $table->id();
            $table->unsignedBigInteger('part_id');
            $table->foreign('part_id')->references('part_id')->on('participants')->onDelete('cascade');
            $table->unsignedBigInteger('eve_id');
            $table->foreign('eve_id')->references('eve_id')->on('events')->onDelete('cascade');
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
        Schema::dropIfExists('participants_on_events');
    }
}
