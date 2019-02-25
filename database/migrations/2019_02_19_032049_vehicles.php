<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Vehicles.
 *
 * @author  The scaffold-interface created at 2019-02-19 03:20:49pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Vehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vehicles',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('vehicle_no');
        
        $table->integer('no_of_seats');
        
        $table->integer('max_allowed');
        
        $table->String('contact_person');
        
        $table->date('insurance_renewal_date');
        
        $table->String('track_id');
        
        /**
         * Foreignkeys section
         */
        
        $table->integer('vehicletype_id')->unsigned()->nullable();
        $table->foreign('vehicletype_id')->references('id')->on('vehicletypes')->onDelete('cascade');
        
        
        $table->timestamps();
        
        
        $table->softDeletes();
        
        // type your addition here

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('vehicles');
    }
}
