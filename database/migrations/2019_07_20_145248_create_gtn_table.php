<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location');
            $table->foreign ('location')->references('id')->on('location')->onDelete('cascade');
            $table->integer('destination_location');
            $table->foreign ('destination_location')->references('id')->on('location')->onDelete('cascade');
            $table->text('remarks');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gtn');
    }
}
