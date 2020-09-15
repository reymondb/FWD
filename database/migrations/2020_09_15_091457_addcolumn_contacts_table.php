<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnContactsTable extends Migration
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
                $table->string('PhoneCode')->after('LandlineNum')->nullable();
                $table->string('ListID')->after('PhoneCode')->nullable(); 
            });
        }
        if (Schema::hasTable('new_leads')) {
            Schema::table('new_leads', function (Blueprint $table) {
                $table->string('PhoneCode')->after('LandlineNum')->nullable();
                $table->string('ListID')->after('PhoneCode')->nullable(); 
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
        
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('PhoneCode');
                $table->dropColumn('ListID');
            });
        }
        if (Schema::hasTable('new_leads')) {
            Schema::table('new_leads', function (Blueprint $table) {
                $table->dropColumn('PhoneCode');
                $table->dropColumn('ListID');
            });
        }
    }
}
