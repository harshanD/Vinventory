<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrnHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location')->unsigned();
            $table->foreign('location')->references('id')->on('location')->onDelete('cascade');
            $table->integer('supplier')->unsigned();
            $table->foreign('supplier')->references('id')->on('supplier')->onDelete('cascade');
            $table->integer('invoice')->unsigned();
            $table->foreign('invoice')->references('id')->on('invoice')->onDelete('cascade');
            $table->double('total_net_with_tax');
            $table->double('total_net_without_tax');
            $table->double('total_discount');
            $table->tinyInteger('status');
            $table->tinyInteger('tax_status');
            $table->integer('authorized_or_rejected_by');
            $table->integer('authorized_or_rejected_timestamp');
            $table->string('remarks');
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
        Schema::dropIfExists('grn_header');
    }
}
