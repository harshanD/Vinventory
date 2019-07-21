<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_header')->unsigned();
            $table->foreign ('po_header')->references('id')->on('po_header')->onDelete('cascade');
            $table->integer('item_id')->unsigned();
            $table->foreign ('item_id')->references('id')->on('products')->onDelete('cascade');
            $table->double('cost_price');
            $table->double('qty');
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
        Schema::dropIfExists('po_details');
    }
}
