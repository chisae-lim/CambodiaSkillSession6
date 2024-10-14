<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/get/hosts/by/area/{id_area}',[ApiController::class,'getHostsByAreaID']);
Route::get('/get/guests/by/area/{id_area}/host/{id_host}',[ApiController::class,'getGuestsByAreaIDAndHostID']);
