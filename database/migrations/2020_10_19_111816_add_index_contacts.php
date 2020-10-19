<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {    
                $table->string('MobileNum')->index()->change(); 
                $table->string('LandlineNum')->index()->change();
                $table->string('Email')->index()->change();
                $table->string('FirstName')->index()->change();  
                $table->string('LastName')->index()->change();              
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
