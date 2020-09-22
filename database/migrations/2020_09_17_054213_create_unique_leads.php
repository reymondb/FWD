<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniqueLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unique_leads', function (Blueprint $table) {
            $table->id();
            $table->string('MobileNum')->nullable();
            $table->string('LandlineNum')->nullable();
            $table->string('PhoneCode')->nullable();
            $table->string('ListID')->nullable();
            $table->string('FirstName')->nullable();
            $table->string('LastName')->nullable();
            $table->string('Address')->nullable();
            $table->string('City')->nullable();
            $table->string('State')->nullable();
            $table->string('Zip')->nullable();
            $table->string('Email')->nullable();
            $table->string('OptInWhere')->nullable();
            $table->string('OptInWhen')->nullable();
            $table->string('DateFirstImported')->nullable();
            $table->string('LastDNCWashing')->nullable();
            $table->string('LastDNCResult')->nullable();
            $table->integer('checker')->default(0);
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
        Schema::dropIfExists('unique_leads');
    }
}
