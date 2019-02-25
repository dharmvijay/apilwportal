<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Drivers.
 *
 * @author  The scaffold-interface created at 2019-02-22 07:47:44am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Drivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('drivers',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('name');
        
        $table->String('present_address');
        
        $table->String('permanent_address');
        
        $table->date('date_of_birth');
        
        $table->String('phone');
        
        $table->String('license_number');
        
        /**
         * Foreignkeys section
         */
        
        $table->integer('vehicle_id')->unsigned()->nullable();
        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        
        
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
        Schema::drop('drivers');
    }
}
