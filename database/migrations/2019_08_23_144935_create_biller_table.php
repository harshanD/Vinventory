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
            $table->string('company');
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable()->length(12);
            $table->string('address');
            $table->string('invoice_footer');
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
        Schema::dropIfExists('biller');
    }
}
