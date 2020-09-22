<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDuplicateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('duplicate_leads')) {
            Schema::table('duplicate_leads', function (Blueprint $table) {
                $table->dropColumn('id');
            });
        }
        if (Schema::hasTable('duplicate_leads')) {
            Schema::table('duplicate_leads', function (Blueprint $table) {
                $table->integer('id')->nullable();
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
    }
}
