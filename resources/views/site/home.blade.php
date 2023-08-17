@extends('site.layouts.layout')

@section('content')

<script src="{{ asset('js/search-map.js') }}"></script>

<!-- Welcome Area Start -->
<section class="welcome-area">
        <div class="welcome-slides owl-carousel">
            <!-- Single Welcome Slide -->
            <div class="single-welcome-slide bg-img bg-overlay" style="background-image: url(img/bg-img/16.jpg);" data-img-url="img/bg-img/16.jpg">
                <!-- Welcome Content -->
                <div class="welcome-content h-100">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <!-- Welcome Text -->
                            <div class="col-12">
                                <div class="welcome-text text-center">
                                    <h6 data-animation="fadeInLeft" data-delay="200ms">{{ __('Hotels') }}, {{ __('Restaurants') }} &amp; {{ __('Chalets') }}</h6>
                                    <h2 data-animation="fadeInLeft" data-delay="500ms">{{ __('Welcome To Wen') }}</h2>
                                    <a href="#" class="btn roberto-btn btn-2" data-animation="fadeInLeft" data-delay="800ms">{{ __('Discover Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Welcome Slide -->
            <div class="single-welcome-slide bg-img bg-overlay" style="background-image: url(img/bg-img/17.jpg);" data-img-url="img/bg-img/17.jpg">
                <!-- Welcome Content -->
                <div class="welcome-content h-100">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <!-- Welcome Text -->
                            <div class="col-12">
                                <div class="welcome-text text-center">
                                    <h6 data-animation="fadeInUp" data-delay="200ms">{{ __('Hotels') }}, {{ __('Restaurants') }} &amp; {{ __('Chalets') }}</h6>
                                    <h2 data-animation="fadeInUp" data-delay="500ms">{{ __('Welcome To Wen') }}</h2>
                                    <a href="#" class="btn roberto-btn btn-2" data-animation="fadeInUp" data-delay="800ms">{{ __('Discover Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Welcome Slide -->
            <div class="single-welcome-slide bg-img bg-overlay" style="background-image: url(img/bg-img/18.jpg);" data-img-url="img/bg-img/18.jpg">
                <!-- Welcome Content -->
                <div class="welcome-content h-100">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <!-- Welcome Text -->
                            <div class="col-12">
                                <div class="welcome-text text-center">
                                    <h6 data-animation="fadeInDown" data-delay="200ms">{{ __('Hotels') }}, {{ __('Restaurants') }} &amp; {{ __('Chalets') }}</h6>
                                    <h2 data-animation="fadeInDown" data-delay="500ms">{{ __('Welcome To Wen') }}</h2>
                                    <a href="#" class="btn roberto-btn btn-2" data-animation="fadeInDown" data-delay="800ms">{{ __('Discover Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Welcome Area End -->

    <!-- About Us Area Start -->
    <section class="roberto-about-area section-padding-100-0">
        <!-- Hotel Search Form Area -->
        <div class="hotel-search-form-area">
            <div class="container-fluid">
                <div class="hotel-search-form">
                    <div class="d-flex justify-content-center mb-5">
                        <a href="#" class="mx-2 btn show-form btn-active" data-form="form1"><i class="fa fa-hotel"></i> Hotels</a>
                        <a href="#" class="mx-2 btn custom-btn show-form" data-form="form2"><i class="fa fa-house"></i> Chalets</a>
                        <a href="#" class="mx-2 btn custom-btn show-form" data-form="form3"><i class="fa-solid fa-utensils"></i> Restaurants</a>
                    </div>
                    <form action="{{ route('hotels', ['language'=>app()->getLocale()]) }}" method="get" id="form1" style="display: none;">
                        <div class="row justify-content-between align-items-end">
                            <div class="col-6 col-md-2 col-lg-3">
                                <label for="checkIn">{{ __('Check In') }}</label>
                                <input type="date" class="form-control" id="checkinDate" name="checkinDate">
                            </div>
                            <div class="col-6 col-md-2 col-lg-3">
                                <label for="checkOut">{{ __('Check Out') }}</label>
                                <input type="date" class="form-control" id="checkoutDate" name="checkoutDate">
                            </div>
                            <div class="col-4 col-md-1">
                                <label for="adults">{{ __('Guests') }}</label>
                                <select name="guests" id="guests" class="form-control">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                </select>
                            </div>
                            <div class="col-4 col-md-1">
                                <label for="adults">{{ __('Stars') }}</label>
                                <select name="stars" id="stars" class="form-control">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="form-control btn roberto-btn w-100">{{ __('Check Availability') }}</button>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <button type="button" id="showHotelsMap" class="form-control btn roberto-btn w-100">{{ __('View on Map') }}</button>
                                <button type="button" id="hideHotelsMap" class="form-control btn roberto-btn w-100" style="display:none;">{{ __('Hide Map') }}</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('chalets', ['language'=>app()->getLocale()]) }}" method="get" id="form2" style="display: none;">
                        <div class="row justify-content-between align-items-end">
                            <div class="col-6 col-md-2 col-lg-3">
                                <label for="checkIn">{{ __('Check In') }}</label>
                                <input type="datetime-local" class="form-control" id="checkinDate" name="checkinDate">
                                @error('checkinDate')
                                    <span class="text-danger"><small>{{ __($message) }}</small></span>
                                @enderror
                            </div>
                            <div class="col-6 col-md-2 col-lg-3">
                                <label for="checkOut">{{ __('Check Out') }}</label>
                                <input type="datetime-local" class="form-control" id="checkoutDate" name="checkoutDate">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="form-control btn roberto-btn w-100">{{ __('Check Availability') }}</button>
                            </div>
                        </div>
                        <p id="errorText" style="color: red; display: none;"><small>{{ __('The time interval must be a multiple of 12 hours.') }}</small></p>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <button type="button" id="showChaletsMap" class="form-control btn roberto-btn w-100">{{ __('View on Map') }}</button>
                                <button type="button" id="hideChaletsMap" class="form-control btn roberto-btn w-100" style="display:none;">{{ __('Hide Map') }}</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('restaurents', ['language'=>app()->getLocale()]) }}" method="get" id="form3" style="display: none;">
                        <div class="row justify-content-between align-items-end">
                            <div class="col-6 col-md-2 col-lg-3">
                                <label for="checkIn">{{ __('Check In') }}</label>
                                <input type="datetime-local" class="form-control" id="checkinDate" name="checkinDate">
                            </div>
                            <div class="col-6 col-md-2 col-lg-3">
                                <label for="checkOut">{{ __('Check Out') }}</label>
                                <input type="datetime-local" class="form-control" id="checkoutDate" name="checkoutDate">
                            </div>
                            <div class="col-4 col-md-1">
                                <label for="adults">{{ __('Guests') }}</label>
                                <select name="adults" id="adults" class="form-control">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="form-control btn roberto-btn w-100">{{ __('Check Availability') }}</button>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <button type="button" id="showRestaurantsMap" class="form-control btn roberto-btn w-100">{{ __('View on Map') }}</button>
                                <button type="button" id="hideRestaurantsMap" class="form-control btn roberto-btn w-100" style="display:none;">{{ __('Hide Map') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-100">

            <div id="map" style="width: 100%; height: 0;overflow: hidden;
            transition: height 1s"></div>

            <div class="row align-items-center mt-5">
                <div class="col-12 col-lg-6">
                    <!-- Section Heading -->
                    <div class="section-heading wow fadeInUp" data-wow-delay="100ms">
                        <h6>{{ __('About Us') }}</h6>
                        <h2>{{ __('Welcome To Wen') }}</h2>
                    </div>
                    <div class="about-us-content mb-100">
                        <h5 class="wow fadeInUp" data-wow-delay="300ms">With over 340 hotels worldwide, NH Hotel Group offers a wide variety of hotels catering for a perfect stay no matter where your destination.</h5>
                        <p class="wow fadeInUp" data-wow-delay="400ms">Manager: <span>Michen Taylor</span></p>
                        <img src="img/core-img/signature.png" alt="" class="wow fadeInUp" data-wow-delay="500ms">
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="about-us-thumbnail mb-100 wow fadeInUp" data-wow-delay="700ms">
                        <div class="row no-gutters">
                            <div class="col-6">
                                <div class="single-thumb">
                                    <img src="img/bg-img/13.jpg" alt="">
                                </div>
                                <div class="single-thumb">
                                    <img src="img/bg-img/14.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="single-thumb">
                                    <img src="img/bg-img/15.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Area End -->

@endsection

@section('script')

<script>
    $(document).ready(function () {
        // Show the default form on page load
        $('#form1').show();
        
        // Attach click event handler to show/hide forms
        $('.show-form').click(function (e) {
            hideAllMaps(map);
            e.preventDefault();
            var formToShow = $(this).data('form');
            $('.hotel-search-form form').hide();
            $('#' + formToShow).show();
            $('.btn-active').addClass('custom-btn');
            $('.btn-active').removeClass('btn-active');
            $(this).removeClass('custom-btn');
            $(this).addClass('btn-active');
        });
    });


    $(document).ready(function() {
        $('#form2').on('submit', function(event) {
            const checkinDate = new Date($('#checkinDate').val());
            const checkoutDate = new Date($('#checkoutDate').val());
            const timeDifference = (checkoutDate - checkinDate) / (1000 * 60 * 60); // Difference in hours
            
            if (timeDifference % 12 !== 0) {
            event.preventDefault(); // Prevent form submission
            $('#errorText').show();
            }
        });
    });

    // Initialize the map
    var map = L.map('map', {
            scrollWheelZoom: false, // Disable scroll wheel zoom
        }).setView([51.565, -0.1], 13); // Default initial view

    // Add a tile layer from OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    $('#showHotelsMap').on('click', function() {
        showHotelsMap(map);
        $('#map').animate({
            height: '450px'
        }, 500);
        setTimeout(function(){ map.invalidateSize()}, 1500);
        $('#hideHotelsMap').show();
        $('#showHotelsMap').hide();
    });

    $('#hideHotelsMap').on('click', function() {
        $('#map').animate({
            height: '0px'
        }, 500);
        $('#hideHotelsMap').hide();
        $('#showHotelsMap').show();
        removeMarkers(map);
    });

    $('#showChaletsMap').on('click', function() {
        showChaletsMap(map);
        $('#map').animate({
            height: '450px'
        }, 500);
        setTimeout(function(){ map.invalidateSize()}, 1500);
        $('#hideChaletsMap').show();
        $('#showChaletsMap').hide();
    });

    $('#hideChaletsMap').on('click', function() {
        $('#map').animate({
            height: '0px'
        }, 500);
        $('#hideChaletsMap').hide();
        $('#showChaletsMap').show();
        removeMarkers(map);
    });

    $('#showRestaurantsMap').on('click', function() {
        showRestaurantsMap(map);
        $('#map').animate({
            height: '450px'
        }, 500);
        setTimeout(function(){ map.invalidateSize()}, 1500);
        $('#hideRestaurantsMap').show();
        $('#showRestaurantsMap').hide();
    });

    $('#hideRestaurantsMap').on('click', function() {
        $('#map').animate({
            height: '0px'
        }, 500);
        $('#hideRestaurantsMap').hide();
        $('#showRestaurantsMap').show();
        removeMarkers(map);
    });

    function hideAllMaps(map) {
        $('#map').animate({
            height: '0px'
        }, 500);

        $('#hideHotelsMap').hide();
        $('#showHotelsMap').show();

        $('#hideRestaurantsMap').hide();
        $('#showRestaurantsMap').show();

        $('#hideChaletsMap').hide();
        $('#showChaletsMap').show();

        removeMarkers(map);
    }
</script>
@stop