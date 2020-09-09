<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $fillable = ['MobileNum', 'LandlineNum', 'FirstName', 'LastName', 'Address', 'Email', 'OptInWhere', 'OptInWhen', 'DateFirstImported', 'LastDNCWashing', 'LastDNCResult'];
}
