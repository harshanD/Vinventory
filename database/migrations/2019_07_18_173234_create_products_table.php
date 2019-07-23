<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            $table->string('item_code')->unique();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('img_url')->nullable();
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('brand')->unsigned();
            $table->foreign('brand')->references('id')->on('brands')->onDelete('cascade');
            $table->integer('supplier')->unsigned();
            $table->foreign('supplier')->references('id')->on('supplier')->onDelete('cascade');
            $table->double('selling_price');
            $table->double('cost_price');
            $table->double('availability');
            $table->tinyInteger('status')->length(2)->comment('1=delete,0=active')->default(0);
            $table->integer('status_tax')->nullable();
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
        Schema::dropIfExists('products');
    }
}
