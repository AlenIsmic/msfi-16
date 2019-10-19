<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIznoseNaknadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iznose_naknades', function (Blueprint $table) {
            $table->increments('id');
            $table->double('iznos_nakande');
            $table->unsignedInteger('ugovor_id');
            $table->timestamps();

            $table->foreign('ugovor_id')->references('id')->on('ugovors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iznose_naknades');
    }
}
