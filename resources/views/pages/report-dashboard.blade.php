@extends('layouts.main')

@section('title')
@endsection

@section('body')
    <div class="row">
        <div class="col-auto">
            @include('layouts.sidebar')
        </div>
        <div class="col my-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab1">Universal
                        Report</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab2">Service
                        Report</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#tab3">Host
                        Analysis</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <h6>Property or Listing Summary</h6>
                                <div class="border border-secondary p-3">
                                    <h6>Secured past booking: {{ count($secured_bookings) }}</h6>
                                    <h6>Upcomming booking: {{ count($upcomming_bookings) }}</h6>
                                    <h6>Most booked day of the week: {{ $most_booked_day_of_the_week->day_name }}</h6>
                                    <h6>Inactive listings or properties: {{ count($inactive_properties) }}</h6>
                                    <h6>Cancelled Reservations: {{ count($cancelled_reservations) }}</h6>
                                    <h6>Most used coupon:
                                        @foreach ($most_used_coupons as $coupon)
                                            {{ $coupon->CouponCode }},
                                        @endforeach
                                    </h6>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <h6>Filter</h6>
                            </div>
                            <div class="col-6 mt-3">
                                <h6>Filter</h6>
                            </div>
                            <div class="col-6 mt-3">
                                <h6>Filter</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="tab2">
                    tab2

                </div>
                <div class="tab-pane fade" id="tab3">
                    tab3

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
