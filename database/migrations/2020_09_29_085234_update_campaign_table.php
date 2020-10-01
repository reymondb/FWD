<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (Schema::hasTable('campaign')) {
            Schema::table('campaign', function (Blueprint $table) {
                $table->string('MySQL_host')->after('CampaignName')->nullable();
                $table->string('Mysql_db')->after('MySQL_host')->nullable(); 
                $table->string('Mysql_username')->after('Mysql_db')->nullable(); 
                $table->string('Mysql_password')->after('Mysql_username')->nullable(); 
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
        if (Schema::hasTable('campaign')) {
            Schema::table('campaign', function (Blueprint $table) {
                $table->dropColumn('MySQL_host');
                $table->dropColumn('Mysql_db');
                $table->dropColumn('Mysql_username');
                $table->dropColumn('Mysql_password');
            });
        }
    }
}
