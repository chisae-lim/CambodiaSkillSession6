<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Item;
use App\Models\Coupon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    function ReportDashboard()
    {
        $areas = Area::has('items.prices.booking_details')->orderBy('Name', 'asc')->get();
        $secured_bookings = Booking::whereHas('booking_details', function ($q) {
            $q->where('isRefund', 0)
                ->whereHas('price', function ($q) {
                    $q->where('Date', '<=', date('Y-m-d'));
                });
        })->get();
        $upcomming_bookings = Booking::whereHas('booking_details', function ($q) {
            $q->where('isRefund', 0)
                ->whereHas('price', function ($q) {
                    $q->where('Date', '>', date('Y-m-d'));
                });
        })->get();
        $most_booked_day_of_the_week = DB::table('itemprices') //itemprices 1 -> M bookingdetails
            ->join('bookingdetails', 'bookingdetails.ItemPriceID', 'itemprices.ID')
            ->where('isRefund', 0)
            ->selectRaw('DAYNAME(DATE) AS day_name')
            ->selectRaw('COUNT(*) AS total_day')
            ->groupBy('day_name')
            ->orderBy('total_day', 'desc')
            ->first();

        $inactive_properties = Item::doesntHave('prices')->get();

        $cancelled_reservations = Booking::has('booking_details')
            ->whereDoesntHave('booking_details', function ($q) {
                $q->where('isRefund', 0);
            })->get();

        $used_coupons = DB::table('coupons')
            ->join('bookings', 'bookings.CouponID', 'coupons.ID')
            ->join('bookingdetails', 'bookingdetails.BookingID', 'bookings.ID')
            ->select('coupons.ID', 'coupons.CouponCode')
            ->where('isRefund', 0)
            ->selectRaw('(COUNT(*)) AS total_used')
            ->groupBy('coupons.ID', 'coupons.CouponCode')
            ->orderBy('total_used', 'desc')
            ->get();
        $most_used_coupons = [];
        foreach ($used_coupons as $coupon) {
            if ($coupon->total_used ===  $used_coupons[0]->total_used) {
                $most_used_coupons[] = $coupon;
            } else {
                break;
            }
        }

        $average_score = DB::table('itemscores')
        ->selectRaw('SUM(Value)/COUNT(*) as total_value')
        ->first();

    $highest_score_item = DB::table('items')
        ->join('itemscores', 'itemscores.ItemID', 'items.ID')
        ->select('items.ID', 'items.Title')

        ->selectRaw('(SUM(Value)) AS total_value')
        ->groupBy('items.ID', 'items.Title')
        ->orderBy('total_value', 'desc')
        ->first();

    $top_owner = DB::table('users')
        ->join('items', 'items.UserID', 'users.ID')
        ->join('itemscores', 'itemscores.ItemID', 'items.ID')
        ->select('users.ID', 'users.FullName')

        ->selectRaw('(SUM(Value)) AS total_value')
        ->groupBy('users.ID', 'users.FullName')
        ->orderBy('total_value', 'desc')
        ->first();

    $least_clean_owner = DB::table('users')
        ->join('items', 'items.UserID', 'users.ID')
        ->join('itemscores', 'itemscores.ItemID', 'items.ID')
        ->where('ScoreID', 2)
        ->select('users.ID', 'users.FullName')

        ->selectRaw('(SUM(Value)) AS total_value')
        ->groupBy('users.ID', 'users.FullName')
        ->orderBy('total_value', 'asc')
        ->first();



        $number_of_purchased_service = DB::table('addonservicedetails')
        ->where('FromDate','<',date('Y-m-d H:i:s.u'))
        ->where('isRefund',0)
        ->count();


        $most_booked_service = DB::table('servicetypes')
        ->join('services','services.ServiceTypeID','servicetypes.ID')
        ->join('addonservicedetails','addonservicedetails.ServiceID','services.ID')
        ->where('isRefund',0)
        ->select('servicetypes.ID','servicetypes.Name')
        ->selectRaw('COUNT(*) as total_service_used')
        ->groupBy('servicetypes.ID','servicetypes.Name')
        ->orderBy('total_service_used','desc')
        ->get();

        // dd($most_booked_service);
        return view('pages.report-dashboard', [
            'areas' => $areas,
            'secured_bookings' => $secured_bookings,
            'upcomming_bookings' => $upcomming_bookings,
            'most_booked_day_of_the_week' => $most_booked_day_of_the_week,
            'inactive_properties' => $inactive_properties,
            'cancelled_reservations' => $cancelled_reservations,
            'most_used_coupons' => $most_used_coupons,
            'average_score' => $average_score,
            'highest_score_item' => $highest_score_item,
            'top_owner' => $top_owner,
            'least_clean_owner' => $least_clean_owner,
            'number_of_purchased_service' => $number_of_purchased_service,
        ]);
    }
}
