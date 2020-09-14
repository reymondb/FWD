<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnLeadsAndBatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->after('password')->nullable();              
            });
        }
        //
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('supplier_id')->after('LastDNCResult')->nullable();              
            });
        }
        if (Schema::hasTable('lead_batch')) {
            Schema::table('lead_batch', function (Blueprint $table) {
                $table->string('supplier_id')->after('FileName')->nullable();              
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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');             
            });
        }
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('supplier_id');             
            });
        }
        if (Schema::hasTable('lead_batch')) {
            Schema::table('lead_batch', function (Blueprint $table) {
                $table->dropColumn('supplier_id');             
            });
        }
    }
}
