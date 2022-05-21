<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId("day_id")->constrained()->onDelete("cascade"); 
            $table->foreignId("facility_id")->constrained()->onDelete("cascade"); 
            $table->timestamp('start_date')->default(\DB::raw('UTC_TIMESTAMP'));
            $table->timestamp('end_date')->default(\DB::raw('UTC_TIMESTAMP'));
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
        Schema::dropIfExists('day_facility');
    }
};