<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcontractorWorkitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcontractor_workitem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subcontractor_id');
            $table->unsignedBigInteger('workitem_id');
            
            $table->timestamps();

            $table->foreign('subcontractor_id')->references('id')->on('subcontractors')->onDelete('cascade');
            $table->foreign('workitem_id')->references('id')->on('workitems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcontractor_workitem');
    }
}
