<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatReal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('real', function (Blueprint $table) {
            $table->integer('idKotaAsal')->unsigned();
            $table->integer('idKotaTujuan')->unsigned();
            $table->integer('gCost')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('real');
    }
}
