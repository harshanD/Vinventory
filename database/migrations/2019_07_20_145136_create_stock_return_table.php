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
            $table->string('return_reference_code')->unique();
            $table->integer('location')->unsigned();
            $table->foreign('location')->references('id')->on('locations')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('biller')->unsigned();
            $table->foreign('biller')->references('id')->on('biller')->onDelete('cascade');
            $table->integer('customer')->unsigned();
            $table->foreign('customer')->references('id')->on('customer')->onDelete('cascade');
            $table->double('discount')->nullable();
            $table->string('discount_val_or_per', 10)->nullable();
            $table->string('tax_per', 10)->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('grand_total');
            $table->integer('return_type')->comment('1=sr,2=mr')->default(1);
            $table->string('return_note')->nullable();
            $table->string('staff_note')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=inactive,0=active')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
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
