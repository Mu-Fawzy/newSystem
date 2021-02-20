<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contract_number', 100)->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subcontractor_id');
            $table->unsignedBigInteger('workitem_id');
            $table->unsignedBigInteger('worksite_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subcontractor_id')->references('id')->on('subcontractors')->onDelete('cascade');
            $table->foreign('workitem_id')->references('id')->on('workitems')->onDelete('cascade');
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
        Schema::dropIfExists('contracts');
    }
}
