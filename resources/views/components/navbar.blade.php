<nav class="container d-flex justify-content-between align-items-center">
    <div class="align-middle mr-10">
        <a class="text-16-medium call-phone hover-up" href="tel:{{json_decode($contacts->long_description)->phone1}}">{{json_decode($contacts->long_description)->phone1}}</a>
        <a class="text-16-medium call-email hover-up ml-5" href="mailto:{{json_decode($contacts->long_description)->email}}">{{json_decode($contacts->long_description)->email}}</a>
    </div>
    <div class="align-middle text-18-medium mr-10 mt-2">
        <a target="_blank" href="{{json_decode($contacts->long_description)->social->facebook}}" class="call-fb"></a>
        <a target="_blank" href="{{json_decode($contacts->long_description)->social->instagram}}" class="call-insta"></a>
        <a target="_blank" href="{{json_decode($contacts->long_description)->social->whatsapp}}" class="call-whatsapp"></a>
    </div>
</nav>

<header class="header sticky-bar">
    <div class="container">
        <div class="main-header">
            <div class="header-left">
                <div class="header-logo"><a class="d-flex" href="/"><img style="min-width: 200px;" alt="Logo" src="assets/imgs/logo/logo.png"></a></div>
                <div class="header-nav">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li><a class="active" href="/">Home</a></li>
                            <li><a href="/our-fleets">Our Fleets</a></li>
                            <li class="has-children">
                                <a href="/our-services">Our Services</a>
                                <ul class="sub-menu">
                                    @foreach($services as $service)
                                    <li><a href="/our-services">{{$service->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="/contact-us">Contact Us</a></li>
                        </ul>
                    </nav>
                    <div class="burger-icon burger-icon-white"><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                </div>
                <div class="header-right">
                    <div class="box-button-login d-none2 d-inline-block align-middle"><a class="btn btn-white hover-up" href="/booking">Book Now</a></div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar" style="z-index: 9999999999">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav class="mt-15">
                        <ul class="mobile-menu font-heading">
                            <li><a class="active" href="/">Home</a></li>
                            <li><a href="/our-fleets">Our Fleets</a></li>
                            <li class="has-children"><a href="/our-services">Our Services</a>
                                <ul class="sub-menu">
                                    @foreach($services as $service)
                                        <li><a href="/our-services">{{$service->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="/contact-us">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
