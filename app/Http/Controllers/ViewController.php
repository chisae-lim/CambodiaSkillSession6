<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class ViewController extends Controller
{   
    function ReportDashboard(){
        $areas = Area::has('items.prices.booking_details')->orderBy('Name','asc')->get();
        return view('pages.report-dashboard',['areas'=>$areas]);
    }
}
