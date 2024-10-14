@extends('layouts.main')

@section('title')
@endsection

@section('body')
    <div class="row">
        <div class="col-auto">
            @include('layouts.sidebar')
        </div>
        <div class="col-auto my-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab1">Universal Report</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab2">Service Report</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#tab3">Host Analysis</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1">
                    tab1
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
