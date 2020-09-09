<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('MobileNum');
            $table->string('LandlineNum');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Address')->nullable();
            $table->string('Email')->nullable();
            $table->string('OptInWhere')->nullable();
            $table->string('OptInWhen')->nullable();
            $table->string('DateFirstImported')->nullable();
            $table->string('LastDNCWashing')->nullable();
            $table->string('LastDNCResult')->nullable();
            
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
        Schema::dropIfExists('contacts');
    }
}
