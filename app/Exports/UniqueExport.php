<?php

namespace App\Exports;


use App\Models\NewLeads;
use Maatwebsite\Excel\Concerns\FromCollection;

class UniqueExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return NewLeads::all();
    }
}
