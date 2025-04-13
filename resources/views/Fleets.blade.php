@extends('layouts.default')
@section('main')
    <main class="main">
        <div class="section pt-60 pb-60 bg-primary">
            <div class="container-sub">
                <h1 class="heading-44-medium color-white mb-5">Our Fleet</h1>
                <div class="box-breadcrumb">
                    <ul>
                        <li> <a href="/">Home</a></li>
                        <li> <a href="#">Our Fleet</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="section pt-60 bg-white latest-new-white">
            <div class="container-sub">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-start mb-30">
                        <h2 class="heading-24-medium wow fadeInUp">Choose Your Fleet</h2>
                    </div>
                </div>
                <div class="row mt-30 our-fleet-2">
                    @foreach($fleets as $fleet)
                    <div class="col-md-6 mb-30">
                        <div class="cardFleet wow fadeInUp">
                            <div class="cardInfo"><a href="#">
                                    <h3 class="text-20-medium color-text mb-10">{{$fleet->name}}</h3></a>
                                <p class="text-14 color-text mb-30">{{$fleet->description}}</p>
                            </div>
                            <div class="cardImage mb-30"><a href="#"><img src="{{$fleet->image}}" alt="{{$fleet->name}}"></a></div>
                            <div class="cardInfoBottom">
                                <div class="passenger"><span class="icon-circle icon-passenger"></span><span class="text-14">Passengers: <span>{{$fleet->passengers}}</span></span></div>
                                <div class="luggage"><span class="icon-circle icon-luggage"></span><span class="text-14">Luggage: <span>{{$fleet->luggages}}</span></span></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
