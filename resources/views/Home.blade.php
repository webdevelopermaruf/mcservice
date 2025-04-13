@extends('layouts.default')
@section('main')
    <main class="main">
        <section class="section banner-home1">
            <div class="box-swiper">
                <div class="swiper-container swiper-banner-1 pb-0">
                    <div class="swiper-wrapper">
                        @foreach(json_decode($contents['slider']->long_description) as $s_content)
                        <div class="swiper-slide">
                            <div class="box-cover-image" style="background-image:url({{$s_content}})"></div>
                            <div class="box-banner-info">
                                <p class="text-16 color-white wow fadeInUp">Where Would You Like To Go?</p>
                                <h2 class="heading-52-medium color-white wow fadeInUp">Your Personal <br class="d-none d-lg-block">Chauffeur Services</h2>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="box-pagination-button">
                        <div class="swiper-button-prev swiper-button-prev-banner"></div>
                        <div class="swiper-button-next swiper-button-next-banner"></div>
                        <div class="swiper-pagination swiper-pagination-banner"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pt-120 pb-120 bg-our-fleet">
            <div class="container-sub">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-7">
                        <h2 class="heading-44-medium title-fleet wow fadeInUp">Our Fleet</h2>
                    </div>
                    <div class="col-lg-6 col-5 text-end"><a class="text-16-medium color-primary wow fadeInUp" href="index.html#">More Fleet
                            <svg class="icon-16" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path>
                            </svg></a></div>
                </div>
            </div>
            <div class="box-slide-fleet mt-50">
                <div class="box-swiper">
                    <div class="swiper-container swiper-group-4-fleet pb-0">
                        <div class="swiper-wrapper">
                            @foreach($fleets as $fleet)
                            <div class="swiper-slide">
                                <div class="cardFleet wow fadeInUp">
                                    <div class="cardInfo"><a href="/our-fleets">
                                            <h3 class="text-20-medium color-text mb-10">{{$fleet->name}}</h3></a>
                                        <p class="text-14 color-text mb-30">{{$fleet->description}}</p>
                                    </div>
                                    <div class="cardImage mb-30"><a href="/our-fleets"><img src="{{$fleet->image}}" alt="{{$fleet->name}}"></a></div>
                                    <div class="cardInfoBottom">
                                        <div class="passenger"><span class="icon-circle icon-passenger"></span><span class="text-14">Passengers: <span>{{$fleet->passengers}}</span></span></div>
                                        <div class="luggage"><span class="icon-circle icon-luggage"></span><span class="text-14">Luggage: <span>{{$fleet->luggages}}</span></span></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-pagination-fleet">
                            <div class="swiper-button-prev swiper-button-prev-fleet">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                                </svg>
                            </div>
                            <div class="swiper-button-next swiper-button-next-fleet">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-110">
            <div class="container-sub">
                <div class="text-center">
                    <h2 class="heading-44-medium color-text wow fadeInUp">{{$contents['commitment']->title}}</h2>
                </div>
                <div class="row mt-50 cardIconStyleCircle">
                    @foreach(json_decode($contents['commitment']->long_description) as $commitment)
                    <div class="col-lg-4">
                        <div class="cardIconTitleDesc wow fadeInUp">
                            <div class="cardIcon"><img src="{{$commitment->icon}}" alt="{{$commitment->title}}"></div>
                            <div class="cardTitle">
                                <h5 class="text-20-medium color-text">{{$commitment->title}}</h5>
                            </div>
                            <div class="cardDesc">
                                <p class="text-16 color-text">{{$commitment->desc}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section mb-30 mt-80 box-showcase">
            <div class="bg-showcase pt-100 pb-70">
                <div class="container-sub">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-30">
                            <h2 class="heading-44-medium color-white wow fadeInUp">{{$contents['showcase']->title}}</h2>
                        </div>
                        <div class="col-lg-6">
                            <div class="row align-items-center">
                                @foreach(json_decode($contents['showcase']->long_description) as $showcase)
                                <div class="col-4 mb-30 wow fadeInUp">
                                    <div class="box-number">
                                        <h2 class="heading-44-medium color-white">{{$showcase->value}}</h2>
                                        <p class="text-20 color-white">{{$showcase->label}}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pt-90 pb-120 bg-our-service">
            <div class="container-sub">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-7 col-7">
                        <h2 class="heading-44-medium title-fleet wow fadeInUp">Our Services</h2>
                    </div>
                    <div class="col-lg-6 col-sm-5 col-5 text-end"><a class="text-16-medium color-primary d-flex align-items-center justify-content-end wow fadeInUp" href="index.html#">More Services
                            <svg class="icon-16 ml-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path>
                            </svg></a></div>
                </div>
            </div>
            <div class="box-slide-fleet mt-50">
                <div class="box-swiper">
                    <div class="swiper-container swiper-group-4-service pb-0">
                        <div class="swiper-wrapper">
                            @foreach($services as $service)
                            <div class="swiper-slide">
                                <div class="cardService wow fadeInUp">
                                    <div class="cardInfo">
                                        <h3 class="cardTitle text-20-medium color-white mb-10">{{$service->name}}</h3>
                                        <div class="box-inner-info">
                                            <p class="cardDesc text-14 color-white mb-30">{{$service->description}}</p><a class="cardLink btn btn-arrow-up" href="service-single.html">
                                                <svg class="icon-16" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <div class="cardImage"><img src="{{$service->photo}}" alt="{{$service->name}}"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-pagination-fleet">
                            <div class="swiper-button-prev swiper-button-prev-fleet">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                                </svg>
                            </div>
                            <div class="swiper-button-next swiper-button-next-fleet">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pt-130 pb-130 bg-primary box-testimonials">
            <div class="container-sub">
                <div class="row">
                    <div class="col-lg-5 col-md-6 mb-30">
                        <div class="box-swiper">
                            <div class="swiper-container swiper-group-testimonials pb-50">
                                <div class="swiper-wrapper">
                                    @foreach(json_decode($contents['comments']->long_description) as $comment)
                                    <div class="swiper-slide">
                                        <div class="cardQuote wow fadeInUp">
                                            <div class="box-quote">
                                                <div class="icon-quote"> </div>
                                                <div class="info-quote">
                                                    <h5 class="color-white text-18-medium">{{$comment->name}}</h5>
                                                    <p class="color-white text-14">{{$comment->role}}</p>
                                                </div>
                                            </div>
                                            <div class="content-quote">
                                            {{$comment->comment}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="box-pagination-testimonials mt-40 wow fadeInUp"> <span class="firstNumber"></span><span class="lastNumber"></span>
                                    <div class="swiper-pagination swiper-pagination-testimonials"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 mb-30 text-lg-end text-center d-none d-md-block">
                        <div class="box-video wow fadeInUp"> <a class="btn btn-play popup-youtube hover-up" href="https://www.youtube.com/watch?v=sVPYIRF9RCQ"></a><img src="assets/imgs/page/homepage1/img-video.png" alt="luxride"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pt-80 mb-30 bg-faqs">
            <div class="container-sub">
                <div class="box-faqs">
                    <div class="text-center">
                        <h2 class="color-brand-1 mb-20 wow fadeInUp">Frequently Asked Questions</h2>
                    </div>
                    <div class="mt-60 mb-40">
                        <div class="accordion wow fadeInUp" id="accordionFAQ">
                            @foreach(json_decode($contents['faqs']->long_description) as $faq)
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingOne">
                                    <button class="accordion-button text-heading-5 {{$loop->iteration == 1 ? 'collapsed':'' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse_{{$loop->iteration}}">How do I create an account?</button>
                                </h5>
                                <div class="accordion-collapse collapse {{$loop->iteration == 1 ? 'show':'' }}" id="faqCollapse_{{$loop->iteration}}" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        {{$faq->answer}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
