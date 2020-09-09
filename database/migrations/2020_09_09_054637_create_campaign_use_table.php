<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_use', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ContactID');
            $table->integer('CampaignID');
            $table->string('LoadedDate')->nullable();
            $table->integer('LastDispoID')->nullable();
            
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
        Schema::dropIfExists('campaign_use');
    }
}
