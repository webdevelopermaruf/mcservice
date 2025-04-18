@extends('layouts.default')
@section('main')
    <main class="main">
        <div class="section pt-60 pb-60 bg-primary">
            <div class="container-sub">
                <h1 class="heading-44-medium color-white mb-5">Contact Us</h1>
                <div class="box-breadcrumb">
                    <ul>
                        <li> <a href="/">Home</a></li>
                        <li> <a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="section pt-60 pb-60">
            <div class="container-sub">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 mb-30">
                        <div class="cardContact wow fadeInUp">
                            <div class="cardImage mb-30"><img src="assets/imgs/page/contact/new-york.svg" alt="luxride"></div>
                            <div class="cardInfo">
                                <h6 class="heading-20-medium mb-10">Birmingham Office</h6>
                                <p class="text-16 mb-20">{{json_decode($contacts->long_description)->address}}</p>
                                <p class="text-16 mb-20">{{json_decode($contacts->long_description)->phone2}}</p>
                                <p class="text-16">{{json_decode($contacts->long_description)->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 mb-30">
                        <div class="cardContact wow fadeInUp">
                            <div class="cardImage mb-30"><img src="assets/imgs/page/contact/new-york.svg" alt="luxride"></div>
                            <div class="cardInfo">
                                <h6 class="heading-20-medium mb-10">Wolverhampton Office</h6>
                                <p class="text-16 mb-20">{{json_decode($contacts->long_description)->address2}}</p>
                                <p class="text-16 mb-20">{{json_decode($contacts->long_description)->phone1}}</p>
                                <p class="text-16">{{json_decode($contacts->long_description)->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mw-770" style="display:none">
                        <h2 class="heading-44-medium mb-60 text-center wow fadeInUp">Leave us your info</h2>
                        <div class="form-contact form-comment wow fadeInUp">
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="fullname">Full Name</label>
                                            <input class="form-control" id="fullname" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email</label>
                                            <input class="form-control" id="email" type="text" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="subject">Subject</label>
                                            <input class="form-control" id="subject" type="text" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="message">Message</label>
                                            <textarea class="form-control" id="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit">Get In Touch
                                            <svg class="icon-16 ml-5" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section wow fadeInUp">
            <iframe class="map-contact" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d77778.61857864149!2d-1.854018462890632!3d52.46860029700468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4870942d1b417173%3A0xca81fef0aeee7998!2sBirmingham!5e0!3m2!1sen!2suk!4v1743362125072!5m2!1sen!2suk"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </main>
@endsection
