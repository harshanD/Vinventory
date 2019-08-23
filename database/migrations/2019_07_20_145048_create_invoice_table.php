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
            $table->string('invoice_code')->unique();
            $table->integer('location')->unsigned();
            $table->foreign('location')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('biller')->unsigned();
            $table->double('discount')->nullable();
            $table->double('discount_val_or_per')->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('tax_per')->nullable();
            $table->double('invoice_grand_total');
            $table->date('invoice_date');
            $table->tinyInteger('status')->length(2)->comment('1=inactive,0=active')->default(0);
            $table->tinyInteger('sales_status')->length(2)->comment('1=completed,0=pending')->default(0);
            $table->tinyInteger('payment_status')->length(2)->comment('1=pending,2=due,3=partial,4=paid')->default(1);
            $table->text('sale_note')->nullable();
            $table->text('staff_note')->nullable();
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
        Schema::dropIfExists('invoice');
    }
}
