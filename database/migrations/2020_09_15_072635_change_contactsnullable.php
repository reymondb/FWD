<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeContactsnullable extends Migration
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
                $table->string('MobileNum')->nullable()->change(); 
                $table->string('LandlineNum')->nullable()->change();
                $table->string('FirstName')->nullable()->change();  
                $table->string('LastName')->nullable()->change();              
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
