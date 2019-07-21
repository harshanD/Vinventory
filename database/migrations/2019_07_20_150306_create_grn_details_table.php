<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grn_id')->unsigned();
            $table->foreign ('grn_id')->references('id')->on('grn_header')->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign ('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->double('qty');
            $table->double('price_cost_with_tax');
            $table->double('price_cost_without_tax');
            $table->double('price_selling_with_tax');
            $table->double('price_selling_without_tax');
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
        Schema::dropIfExists('grn_details');
    }
}
