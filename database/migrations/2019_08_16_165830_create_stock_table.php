<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_reference_code', 100);
            $table->string('receive_code', 100)->unique();
            $table->date('receive_date');
            $table->integer('location')->unsigned();
            $table->foreign('location')->references('id')->on('locations')->onDelete('cascade');
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=inactive,0=active')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->userstamps();
            $table->softUserstamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
}
