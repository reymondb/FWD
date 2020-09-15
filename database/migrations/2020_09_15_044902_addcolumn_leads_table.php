<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('City')->after('Address')->nullable(); 
                $table->string('State')->after('City')->nullable();
                $table->string('Zip')->after('State')->nullable();             
            });
        }
        if (Schema::hasTable('new_leads')) {
            Schema::table('new_leads', function (Blueprint $table) {
                $table->string('City')->after('Address')->nullable(); 
                $table->string('State')->after('City')->nullable();
                $table->string('Zip')->after('State')->nullable();             
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
                $table->dropColumn('City');
                $table->dropColumn('State');
                $table->dropColumn('Zip');
            });
        }
        if (Schema::hasTable('new_leads')) {
            Schema::table('new_leads', function (Blueprint $table) {
                $table->dropColumn('City');
                $table->dropColumn('State');
                $table->dropColumn('Zip');
            });
        }
    }
}
