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
            $table->string('referenceCode', 100)->nullable()->unique();
            $table->date('due_date')->nullable();
            $table->double('tax')->unsigned();
            $table->integer('tax_percentage')->unsigned()->default(0);
            $table->double('discount')->unsigned();
            $table->double('discount_val_or_per')->unsigned()->default(0);
            $table->double('grand_total')->unsigned();
            $table->tinyInteger('status')->length(2)->comment('1=received,2=ordered,3=pending,4=canceled')->default(3);
            $table->tinyInteger('payment_status')->length(2)->comment('1=pending,2=due,3=partial,4=paid')->default(1);
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('po_header');
    }
}
