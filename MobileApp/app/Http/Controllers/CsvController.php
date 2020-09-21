<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animals;
use View;
use App\Http\Controllers\Controller;
use App\Imports\ImportCsv;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class CsvController extends Controller
{


  public function index(){
    return View::make('csv.index');
  }


  public function Upload(Request $request){

     $request->validate([
                 'csv_file' => 'required'
             ]);
     Excel::import(new ImportCsv, request()->file('csv_file'));
     return back()->with('success', 'Contacts imported successfully.');
  }



}
