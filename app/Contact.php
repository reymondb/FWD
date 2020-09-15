<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $fillable = ['MobileNum', 'LandlineNum', 'FirstName', 'LastName', 'Address', 'Email', 'OptInWhere', 'OptInWhen', 'DateFirstImported', 'LastDNCWashing', 'LastDNCResult'];

    public function campaign_use()
    {
        return $this->hasOne('App\Models\CampaignUse','id','ContactID');
    }
}
