<?php

namespace App\Exports;


use App\Models\DncLeads;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class DNCLeadsExport implements FromCollection, WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $type)
    {
        $this->type = $type;
    }
    public function collection()
    {
        $type =$this->type;
        if($type==1){
            $query = DB::select("SELECT * FROM (SELECT *,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE LastDNCWashing
                        END AS z
                FROM
                    dnc) AS a
                WHERE
                z BETWEEN CURDATE() - INTERVAL 5 DAY AND CURDATE()");
        }
        else if($type==2){
            $query = DB::select("SELECT * FROM (SELECT *,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE LastDNCWashing
                                        END AS z
                                FROM
                                    dnc) AS a
                            WHERE
                                z BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 5 DAY");
        }
        else if($type==3){
            $query = DB::select("SELECT * FROM (SELECT *,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE LastDNCWashing
                                                END AS z
                                        FROM
                                            dnc) AS a
                                    WHERE
                                        z BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 30 DAY");
        }
        
        else if($type==4){
            $query = DB::select("SELECT * as totals FROM (SELECT *,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE LastDNCWashing
                                                END AS z
                                        FROM
                                            dnc) AS a
                                    WHERE
                                        z < CURDATE() - INTERVAL 60 DAY");
        }
        else{
            $query = DncLeads::all();
        }
        return collect($query);
        
    }
}
