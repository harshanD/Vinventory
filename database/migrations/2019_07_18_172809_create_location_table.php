<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->unique();
            $table->string('address',200);
            $table->integer('telephone');
            $table->string('email',100);
            $table->string('contact_person',100);
            $table->integer('type');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->tinyInteger('status')->length(2)->comment('1=delete,0=active')->default(0);
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
        Schema::dropIfExists('location');
    }
}
