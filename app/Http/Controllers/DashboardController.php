<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Illuminate\Http\Request;
use Excel;
class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard');
    }


    public function exportCSV(){
        $file_name = 'customer_'.date('Y_m_d_H_i_s').'.csv';

        return Excel::download(new CustomerExport, $file_name);
     }


     public function importCSV()
     {
        Excel::import(new CustomerImport,request()->file('file'));

         return back();
     }



}
