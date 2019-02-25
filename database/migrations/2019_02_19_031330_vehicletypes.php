<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Vehicletypes.
 *
 * @author  The scaffold-interface created at 2019-02-19 03:13:30pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Vehicletypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vehicletypes',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('type_name');
        
        /**
         * Foreignkeys section
         */
        
        
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
        Schema::drop('vehicletypes');
    }
}
