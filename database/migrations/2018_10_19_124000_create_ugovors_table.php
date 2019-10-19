<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgovorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugovors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('broj_ugovora');
            $table->string('broj_aneksa_ugovora');
            $table->string('najmodavac');
            $table->string('povezano_lice');
            $table->string('lokacija')->nullable();
            $table->unsignedInteger('vrsta_imovine_id');
            $table->string('opcija_trajanja_ugovora');
            $table->string('izuzece');
            $table->date('pocetak_koristenja_imovine');
            $table->date('istek_ugovora');
            $table->string('neoopozivi_period');
            $table->string('trajanje_otkaznog_roka');
            $table->string('produzenje')->nullable();
            $table->string('trajanje_ugovora')->nullable();
            $table->string('predmet_ugovora');
            $table->string('izuzece2');
            $table->string('moment_placanja');
            $table->string('vrsta_placanja');
            $table->double('unaprijed_placeni_iznos');
            $table->double('pocetni_direktni_troskovi');
            $table->double('troskovi_demontaze');
            $table->double('godisnja_kamatna_stopa');
            $table->double('mjesecna_diskontna_stopa');
            $table->longText('napomena')->nullable();

            $table->timestamps();

            $table->foreign('vrsta_imovine_id')->references('id')->on('vrste_imovines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugovors');
    }
}
