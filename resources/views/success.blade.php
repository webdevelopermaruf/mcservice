@extends('layouts.default')

@section('main')
    <main class="main">
        <section class="section">
            <div class="container-sub">
                <div class="box-completed-booking">
                    <div class="text-center wow fadeInUp"> <img class="mb-20" src="assets/imgs/page/booking/completed.png" style="filter: hue-rotate(90deg);" alt="booking">
                        <h4 class="heading-24-medium color-text mb-10">Thank you, your booking has successful!</h4>
                        <p class="text-14 color-grey mb-40">Booking details has been sent to: {{$invoice->passenger->email}}</p>
                    </div>
                    <div class="box-info-book-border wow fadeInUp">
                        <div class="info-1"> <span class="color-text text-14">Order Number</span><br><span class="color-text text-14-medium">#{{$invoice->id}}</span></div>
                        <div class="info-1"> <span class="color-text text-14">Date</span><br><span class="color-text text-14-medium">{{date('D, M d, Y', strtotime($invoice->updated_at))}}</span></div>
                        <div class="info-1"> <span class="color-text text-14">Total</span><br><span class="color-text text-14-medium">£{{$invoice->fare}}</span></div>
                    </div>
                    <div class="box-booking-border wow fadeInUp">
                        <h6 class="heading-20-medium color-text">Reservation Information</h6>
                        <ul class="list-prices">
                            <li> <span class="text-top">Pick Up Address</span><span class="text-bottom">{{$invoice->from}}</span></li>
                            <li> <span class="text-top">Drop Off Address</span><span class="text-bottom">{{$invoice->to}}</span></li>
                            <li> <span class="text-top">Pick Up Date</span><span class="text-bottom">{{date('D, M d, Y', strtotime($invoice->date))}}</span></li>
                            <li> <span class="text-top">Pick Up Time</span><span class="text-bottom">{{date("g:i A", strtotime($invoice->time))}}</span></li>
                            <li> <span class="text-top">Distance</span><span class="text-bottom">{{$invoice->distance}} Miles</span></li>
                        </ul>
                    </div>
                    @if($invoice->return_date)
                    <div class="box-booking-border wow fadeInUp">
                        <h6 class="heading-20-medium color-text">Return Reservation Information</h6>
                        <ul class="list-prices">
                            <li> <span class="text-top">Pick Up Address</span><span class="text-bottom">{{$invoice->to}}</span></li>
                            <li> <span class="text-top">Drop Off Address</span><span class="text-bottom">{{$invoice->from}}</span></li>
                            <li> <span class="text-top">Pick Up Date</span><span class="text-bottom">{{date('D, M d, Y', strtotime($invoice->return_date))}}</span></li>
                            <li> <span class="text-top">Pick Up Time</span><span class="text-bottom">{{date("g:i A", strtotime($invoice->return_time))}}</span></li>
                            <li> <span class="text-top">Distance</span><span class="text-bottom">{{$invoice->distance}} Miles</span></li>
                        </ul>
                    </div>
                    @endif
                    <div class="box-booking-border wow fadeInUp">
                        <h6 class="heading-20-medium color-text">Selected Car</h6>
                        <div class="mt-20 mb-20 text-center"> <img width="200px" src="{{$invoice->fleet->image}}" alt="{{$invoice->fleet->name}}"></div>
                        <ul class="list-prices">
                            <li> <span class="text-top">Class</span><span class="text-bottom">{{$invoice->fleet->name}}</span></li>
                        </ul>
                    </div>
                    <div class="box-booking-border wow fadeInUp">
                        <h6 class="heading-20-medium color-text">Passenger Information</h6>
                        <ul class="list-prices">
                            <li> <span class="text-top">Full name</span><span class="text-bottom">{{$invoice->passenger->name}}</span></li>
                            <li> <span class="text-top">Email</span><span class="text-bottom">{{$invoice->passenger->email}}</span></li>
                            <li> <span class="text-top">Phone</span><span class="text-bottom">{{$invoice->passenger->phone}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
