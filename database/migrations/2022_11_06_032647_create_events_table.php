<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) 
        {
            $table->bigIncrements('eve_id');
            $table->char('eve_name', 100);
            $table->timestamp('eve_date');
            $table->timestamp('eve_end_date')->nullable();
            $table->char('eve_location', 100);
            $table->char('eve_banner',100);
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
        Schema::dropIfExists('events');
    }
}
