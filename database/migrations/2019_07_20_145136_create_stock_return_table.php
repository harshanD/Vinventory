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
            $table->foreign ('source_location')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('destination_location')->unsigned();
            $table->foreign ('destination_location')->references('id')->on('locations')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('biller')->unsigned();
            $table->foreign ('biller')->references('id')->on('biller')->onDelete('cascade');
            $table->integer('customer_id')->unsigned();
            $table->foreign ('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->integer('return_type')->comment('1=sr,2=mr')->default(1);
            $table->string('return_note')->nullable();
            $table->string('staff_note')->nullable();
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
        Schema::dropIfExists('stock_return');
    }
}
