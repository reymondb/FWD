<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDncLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnc_leads', function (Blueprint $table) {
            $table->id();
            $table->string('MobileNum')->nullable()->index();
            $table->string('LandlineNum')->nullable()->index();
            $table->string('PhoneCode')->nullable();
            $table->string('ListID')->nullable(); 
            $table->string('FirstName')->nullable()->index();
            $table->string('LastName')->nullable()->index();
            $table->string('Address')->nullable();
            $table->string('City')->nullable(); 
            $table->string('State')->nullable();
            $table->string('Zip')->nullable(); 
            $table->string('Email')->nullable()->index();
            $table->string('OptInWhere')->nullable();
            $table->string('OptInWhen')->nullable();
            $table->string('DateFirstImported')->nullable();
            $table->string('LastDNCWashing')->nullable();
            $table->string('LastDNCResult')->nullable();
            $table->string('supplier_id')->index(); 
            $table->string('campaign_id')->index(); 
            $table->string('batch_id')->index(); 
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
        Schema::dropIfExists('dnc_leads');
    }
}
