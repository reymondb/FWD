<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignUse extends Model
{
    //
    protected $table = 'campaign_use';
    protected $primaryKey = 'id';
    
    public function contact()
    {
        return $this->belongsTo('App\Contact','id','ContactID');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaigns','id','CampaignID');
    }

}
