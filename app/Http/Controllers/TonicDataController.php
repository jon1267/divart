<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\TonicDataImport;
use Maatwebsite\Excel\Facades\Excel;

//use App\Services\Import\Csv;

class TonicDataController extends Controller
{
    public function import()
    {
        Excel::import(new TonicDataImport(), public_path('xls\TonicData.xlsx'));

        return redirect('/')->with('success', 'Import OK.');
    }

    /*public function importCsv()
    {
        $data = Csv::parseCsv(public_path('xls\TonicData.csv'), ';');
        dd($data);
    }*/
}
