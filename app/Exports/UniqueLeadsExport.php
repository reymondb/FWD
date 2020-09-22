<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\NewLeads;

use DB;

class UniqueLeadsExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(int $mobile_num,int $landline,int $email)
    {
        $this->mobile_num = $mobile_num;
        $this->email = $email;
        $this->landline = $landline;
    }

    public function query()
    {
        /*$landline =$this->landline;
        $mobile_num =$this->mobile_num;
        $email =$this->email;
        $uniqueleads = DB::select( DB::raw("SELECT `MobileNum`, `LandlineNum`, `PhoneCode`, `ListID`, `FirstName`, `LastName`, `Address`, `City`, `State`, `Zip`, `Email`, `OptInWhere`, `OptInWhen`, `DateFirstImported`, `LastDNCWashing`, `LastDNCResult` FROM        
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
                    contacts b) AS z
                GROUP BY LandlineNum
                HAVING COUNT(*) <= 1
                ORDER BY checker ASC) AS d
            WHERE
                checker = 1
            "));
            
        return json_decode( json_encode($uniqueleads), true);*/
        $uniqueleads =NewLeads::select('id',       
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
            'LastDNCWashing')->get();
                
        return $uniqueleads;
    }

    public function headings() : array
    {
        return [ 'id',          
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
