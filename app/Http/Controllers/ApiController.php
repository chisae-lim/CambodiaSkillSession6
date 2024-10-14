<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function getHostsByAreaID($id_area)
    {
        $hosts = User::whereHas('items', function ($q) use ($id_area) {
            $q->whereHas('area', function ($q) use ($id_area) {
                $q->where('GUID', $id_area);
            })

            
                ->has('prices.booking_details');
        })
            ->orderBy('FullName', 'asc')
            ->get();
        return response($hosts, 200);
    }

    function getGuestsByAreaIDAndHostID($id_area, $id_host)
    {
        $guests = User::whereHas('bookings.booking_details.price.item', function ($q) use ($id_area, $id_host) {
            $q->whereHas('area', function ($q) use ($id_area) {
                $q->where('GUID', $id_area);
            })->whereHas('user', function ($q) use ($id_host) {
                $q->where('GUID', $id_host);
            });
        })->orderBy('FullName', 'asc')
            ->get();

        return response($guests, 200);
    }
}
