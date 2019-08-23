<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoice')->onDelete('cascade');
            $table->string('serial_number');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('products')->onDelete('cascade');
            $table->double('qty')->nullable();
            $table->double('cost_price');
            $table->double('tax_val')->nullable();
            $table->double('tax_per')->nullable();
            $table->double('discount')->nullable();
            $table->double('sub_total');
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
        Schema::dropIfExists('invoice_details');
    }
}
