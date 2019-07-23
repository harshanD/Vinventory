<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_return', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_location')->unsigned();
            $table->foreign ('source_location')->references('id')->on('location')->onDelete('cascade');
            $table->integer('destination_location')->unsigned();
            $table->foreign ('destination_location')->references('id')->on('location')->onDelete('cascade');
            $table->integer('supplier')->unsigned();
            $table->foreign ('supplier')->references('id')->on('supplier')->onDelete('cascade');
            $table->integer('return_type');
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=delete,0=active')->default(0);
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
        Schema::dropIfExists('stock_return');
    }
}
