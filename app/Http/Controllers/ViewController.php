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
        $most_booked_day_of_the_week = DB::table('itemprices')
            ->join('bookingdetails', 'bookingdetails.ItemPriceID', 'itemprices.ID')
            ->where('isRefund', 0)
            ->selectRaw('DAYNAME(DATE) AS day_name')
            ->selectRaw('COUNT(DAYNAME(DATE)) AS total_day')
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
            ->selectRaw('(COUNT(coupons.ID)) AS total_used')
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
        return view('pages.report-dashboard', [
            'areas' => $areas,
            'secured_bookings' => $secured_bookings,
            'upcomming_bookings' => $upcomming_bookings,
            'most_booked_day_of_the_week' => $most_booked_day_of_the_week,
            'inactive_properties' => $inactive_properties,
            'cancelled_reservations' => $cancelled_reservations,
            'most_used_coupons' => $most_used_coupons,
        ]);
    }
}
