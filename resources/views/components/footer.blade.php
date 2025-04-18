<a href="{{json_decode($contacts->long_description)->social->whatsapp}}" style="width: 50px;position:fixed; bottom: 10px; right: 10px; z-index: 99999999999">
    <img style="border-radius: 50%;" src="/assets/imgs/logo/whatsapp.png" alt="">
</a>
<footer class="footer">
    <div class="footer-2">
        <div class="container-sub">
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-12 text-center text-lg-start mb-3">
                        <span class="text-14 color-white mr-50">Copyright © 2024-2025 Mash Chauffeur Service</span>
                        <ul class="menu-bottom">
                            <li><a href="/our-fleets">Our Fleets</a></li>
                            <li><a href="/our-services">Services</a></li>
                            <li><a href="/contact-us">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-8 col-md-12 text-center text-lg-start">
                        <h4 class="text-white">Birmingham Office</h4>
                        <a class="btn btn-link-location" href="#">{{json_decode($contacts->long_description)->address}}</a>
                    </div>
                    <div class="col-lg-4 col-md-12 text-center text-lg-end">
                        <h4 class="text-white">Wolverhampton Office</h4>
                        <a class="btn btn-link-location" href="#">{{json_decode($contacts->long_description)->address2}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
