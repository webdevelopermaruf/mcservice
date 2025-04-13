@extends('layouts.default')

@section('main')
    <main class="main">
        <section class="section">
            <div class="container-sub">
                <div class="box-completed-booking">
                    <div class="text-center wow fadeInUp"> <img class="mb-20" width="100px" src="assets/imgs/page/booking/cancel.svg" style="filter: hue-rotate(90deg);" alt="booking">
                        <h4 class="heading-24-medium color-text mb-10">Oh Sorry, your booking has canceled!</h4>
                        <a href="/booking" class="text-14 color-grey mb-40">Please try again. Go to Booking Page</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
