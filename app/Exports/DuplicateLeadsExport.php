<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
 
use App\Models\DuplicateLeads;

use DB;

class DuplicateLeadsExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        /*
        $landline =$this->landline;
        $mobile_num =$this->mobile_num;
        $email =$this->email;
        //DB::enableQueryLog(); // Enable query log
        $duplicates = DB::select( DB::raw("SELECT `MobileNum`, `LandlineNum`, `PhoneCode`, `ListID`, `FirstName`, `LastName`, `Address`, `City`, `State`, `Zip`, `Email`, `OptInWhere`, `OptInWhen`, `DateFirstImported`, `LastDNCWashing`, `LastDNCResult` FROM        
        (SELECT 
            *
        FROM
            (SELECT `MobileNum`, `LandlineNum`, `PhoneCode`, `ListID`, `FirstName`, `LastName`, `Address`, `City`, `State`, `Zip`, `Email`, `OptInWhere`, `OptInWhen`, `DateFirstImported`, `LastDNCWashing`, `LastDNCResult`,
                '1' AS checker
        FROM
            new_leads a UNION SELECT 
            `MobileNum`, `LandlineNum`, `PhoneCode`, `ListID`, `FirstName`, `LastName`, `Address`, `City`, `State`, `Zip`, `Email`, `OptInWhere`, `OptInWhen`, `DateFirstImported`, `LastDNCWashing`, `LastDNCResult`,
                '2' AS checker
        FROM
            contacts b)  AS z
            GROUP BY LandlineNum
            HAVING COUNT(*) > 1
            ORDER BY checker ASC) AS d
        "));
                   // dd(DB::getQueryLog());die();
        return $duplicates;*/
        $duplicates = DuplicateLeads::select('id',       
        'MobileNum',
        'LandlineNum',
        'PhoneCode',
        'ListID',
        'FirstName',
        'LastName',
        'Address',
        'City',
        'State',
        'Zip',
        'Email',
        'OptInWhere',
        'OptInWhen',
        'DateFirstImported',
        'LastDNCWashing');
            
        return $duplicates;
    }

    public function headings() : array
    {
        return [            
            'id',
        'MobileNum',
        'LandlineNum',
        'PhoneCode',
        'ListID',
        'FirstName',
        'LastName',
        'Address',
        'City',
        'State',
        'Zip',
        'Email',
        'OptInWhere',
        'OptInWhen',
        'DateFirstImported',
        'LastDNCWashing',
        'LastDNCResult'
        ];
    }
}
