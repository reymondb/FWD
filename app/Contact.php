<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $fillable = ['MobileNum', 'LandlineNum', 'FirstName', 'LastName', 'Address', 'Email', 'OptInWhere', 'OptInWhen', 'DateFirstImported', 'LastDNCWashing', 'LastDNCResult'];

    public function campaign_use()
    {
        return $this->hasMany('App\Models\CampaignUse','id','ContactID');
    }

    public static function IndexRaw($index_raw)
    {
        $model = new static();
        $model->setTable(\DB::raw($model->getTable() . ' ' . $index_raw));
        return $model;
    }
}
