<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_leads', function (Blueprint $table) {
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
        Schema::dropIfExists('new_leads');
    }
}
