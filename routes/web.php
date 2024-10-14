<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/report-dashboard',[ViewController::class,'ReportDashboard']);