<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Tests.
 *
 * @author  The scaffold-interface created at 2019-02-16 07:27:41pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Tests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('tests',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('name');
        
        /**
         * Foreignkeys section
         */
        
        $table->integer('task_id')->unsigned()->nullable();
        $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
        
        
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
        Schema::drop('tests');
    }
}
