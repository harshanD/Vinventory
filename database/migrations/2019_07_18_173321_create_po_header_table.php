<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location')->unsigned();
            $table->foreign('location')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('supplier')->unsigned();
            $table->foreign('supplier')->references('id')->on('supplier')->onDelete('cascade');
            $table->date('due_date')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=inactive,0=active')->default(0);
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('po_header');
    }
}
