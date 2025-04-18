<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Mash Chauffeur Service</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="description" content="Index page">
    <meta name="keywords" content="index, page">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/logo/icon.png">
    <link href="assets/css/style.css@v=1.0.0.css" rel="stylesheet">
    <title>Mash Chauffeur Service - Your Comfort, Our Priority</title>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUplFLQJttGXu131R5JYQCqkEPDQeO7gY&libraries=places"
        loading="async"
    ></script>
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body>
@include('components.navbar')
@inertia
@include('components.footer')
<script src="assets/js/vendors/modernizr-3.6.0.min.js"></script>
<script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendors/jquery-migrate-3.3.0.min.js"></script>
<script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="assets/js/vendors/waypoints.js"></script>
<script src="assets/js/vendors/wow.js"></script>
<script src="assets/js/vendors/magnific-popup.js"></script>
<script src="assets/js/vendors/perfect-scrollbar.min.js"></script>
<script src="assets/js/vendors/select2.min.js"></script>
<script src="assets/js/vendors/isotope.js"></script>
<script src="assets/js/vendors/scrollup.js"></script>
<script src="assets/js/vendors/swiper-bundle.min.js"></script>
<script src="assets/js/vendors/noUISlider.js"></script>
<script src="assets/js/vendors/slider.js"></script>
<!-- Count down-->
{{--<script src="assets/js/vendors/counterup.js"></script>--}}
{{--<script src="assets/js/vendors/jquery.countdown.min.js"></script>--}}
<!-- Count down-->

<script src="assets/js/vendors/jquery.elevatezoom.js"></script>
<script src="assets/js/vendors/slick.js"></script>
<script src="assets/js/vendors/jquery-ui.js"></script>
<script src="assets/js/vendors/jquery.timepicker.min.js"></script>
<script src="assets/js/main.js@v=1.0.0" type="text/javascript"></script>
</body>
</html>
