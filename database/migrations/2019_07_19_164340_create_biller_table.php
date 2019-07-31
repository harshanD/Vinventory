<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biller', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company')->nullable();
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable()->length(12);
            $table->string('address')->nullable();
            $table->text('invoice_footer')->nullable();
            $table->tinyInteger('status')->length(2)->comment('1=inactive,0=active')->default(0);
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
        Schema::dropIfExists('biller');
    }
}
