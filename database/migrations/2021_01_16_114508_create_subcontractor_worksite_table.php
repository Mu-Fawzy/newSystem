<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcontractorWorksiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcontractor_worksite', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subcontractor_id');
            $table->unsignedBigInteger('worksite_id');
            
            $table->timestamps();

            $table->foreign('subcontractor_id')->references('id')->on('subcontractors')->onDelete('cascade');
            $table->foreign('worksite_id')->references('id')->on('worksites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcontractor_worksite');
    }
}
