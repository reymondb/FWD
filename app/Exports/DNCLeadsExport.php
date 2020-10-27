<?php

namespace App\Exports;


use App\Models\DncLeads;
use Maatwebsite\Excel\Concerns\FromCollection;

class DNCLeadsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DncLeads::all();
    }
}
