<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtn_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gtn_id')->unsigned();
            $table->foreign ('gtn_id')->references('id')->on('gtn')->onDelete('cascade');
            $table->integer('product_id');
            $table->double('qty');
            $table->double('cost_price')->nullable();
            $table->double('selling_price')->nullable();
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
        Schema::dropIfExists('gtn_details');
    }
}
