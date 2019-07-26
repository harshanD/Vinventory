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
            $table->integer('location')->unsigned();
            $table->foreign ('location')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('destination_location')->unsigned();
            $table->foreign ('destination_location')->references('id')->on('locations')->onDelete('cascade');
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=inactive,0=active')->default(0);
            $table->softDeletes();
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
