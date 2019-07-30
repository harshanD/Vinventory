<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location')->unsigned();
            $table->foreign ('location')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('biller')->unsigned();
            $table->double('invoice_amount');
            $table->double('discount');
            $table->double('tax');
            $table->date('invoice_date');
            $table->tinyInteger('sales_status')->length(2)->comment('1=inactive,0=active')->default(0);
            $table->tinyInteger('status')->length(2)->comment('1=completed,0=pending')->default(0);
            $table->tinyInteger('payment_status')->length(2)->comment('1=pending,2=due,3=partial,4=paid')->default(1);
            $table->text('sale_note');
            $table->text('staff_note');
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
        Schema::dropIfExists('invoice');
    }
}
