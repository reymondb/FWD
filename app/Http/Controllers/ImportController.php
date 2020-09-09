<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function getImport()
    {
        $campaigns=Campaigns::all();
        return view('dashboard/import')->with('campaigns',$campaigns);
    }

    public function parseImport(CsvImportRequest $request)
    {
        $campaign=$request->campaign;

        $path = $request->file('csv_file')->getRealPath();

        if ($request->has('header')) {
            $data = Excel::load($path, function($reader) {})->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('dashboard/import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('campaign',$campaign);

    }

    public function processImport(Request $request)
    {
        $campaignid= $request->campaign;
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $contact = new Contact();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                    $contact->$field = $row[$request->fields[$field]];
                } else {
                    $contact->$field = $row[$request->fields[$index]];
                }
            }
            $contact->save();
            $campaignuse = new CampaignUse();
            $campaignuse->ContactID = $contact->id;
            $campaignuse->CampaignID = $campaignid;
            $campaignuse->save();
            

        }

        return view('dashboard/import_success');
    }

}
