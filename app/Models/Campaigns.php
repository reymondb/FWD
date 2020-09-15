<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $table = 'campaign';
    protected $primaryKey = 'id';
  
    public function campaign_use()
    {
        return $this->hasMany('App\Models\CampaignUse','CampaignID','id');
    }

}
