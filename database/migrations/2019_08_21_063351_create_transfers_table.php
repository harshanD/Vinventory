<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tr_reference_code', 100);
            $table->string('receive_code', 100)->references('id')->on('stock')->comment('reference from stock');
            $table->date('tr_date');
            $table->integer('from_location')->unsigned();
            $table->foreign('from_location')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('to_location')->unsigned();
            $table->foreign('to_location')->references('id')->on('locations')->onDelete('cascade');
            $table->double('tot_tax')->nullable();
            $table->double('grand_total');
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=completed,2=pending,3=set,4=cancel')->default(0);
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
        Schema::dropIfExists('transfers');
    }
}
