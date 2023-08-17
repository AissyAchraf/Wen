@extends('site.layouts.layout')

@section('content')
    <script src="{{ asset('js/search-map.js') }}"></script>

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('{{ asset('img/bg-img/hotels-bg.jpg')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ __('Hotels') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Hotels') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

    <!-- Rooms Area Start -->
    <div class="roberto-rooms-area section-padding-100-0">
        <div class="container">

            <div id="map" style="width: 100%; height: 0;overflow: hidden;
            transition: height 1s;margin-bottom:40px;"></div>
                
            <div class="row">
                <div class="col-12 col-lg-8">
                    <!-- Single Room Area -->
                    @foreach($hotels as $hotel)
                    <div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Room Thumbnail -->
                        @php
                            $Imageslist = explode(",", $hotel->photos);
                        @endphp
                        <div class="room-thumbnail">
                            <a href="{{ route('hotel', [app()->getLocale(), $hotel->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')]) }}">
                                <img src="{{ asset('/images/Hotels/' . $hotel->id . '/'.$Imageslist[0]) }}" alt="{{$hotel->name.' image'}}">
                            </a>
                        </div>
                        <!-- Room Content -->
                        <div class="room-content">
                            <a href="{{ route('hotel', [app()->getLocale(), $hotel->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')]) }}">
                                <h2>{{$hotel->name}}</h2>
                            </a>
                            <div class="row justify-content-center">
                                <div class="col-7">
                                    <div class="d-flex flex-row">
                                        <div class="text-danger mb-1 me-2">
                                        @for($i = 0; $i < $hotel->stars; $i++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <h6 class="mt-3"><i class="fa fa-map-marker"></i> {{$hotel->address}}</h6>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        @if($hotel->room_service)
                                        <h6 class="text-success"><i class="fa fa-check"></i> Room Service Available</h6>
                                        @else
                                        <h6 class="text-warning"><i class="fa fa-warning"></i> Room Service Not Available</h6>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="d-flex flex-row justify-content-end mb-1">
                                        <div class="bg-success p-2 text-white rounded">4.8 <span style="font-size:10px;">/5</span></div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-end mb-1">
                                        <p>15 {{ __('reviews') }}</p>
                                    </div>
                                    <p></p>
                                    <div class="d-flex flex-row justify-content-end mb-1">
                                        <a href="{{ route('hotel', [app()->getLocale(), $hotel->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')]) }}" class="btn view-detail-btn">View Details <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="row mt-3">
                        {{ $hotels->appends(request()->except('page'))->links('site.paginationLinks') }}
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="form-group mb-3">
                        <button type="button" id="showHotelsMap" class="form-control btn roberto-btn w-100">{{ __('View on Map') }}</button>
                        <button type="button" id="hideHotelsMap" class="form-control btn roberto-btn w-100" style="display:none;">{{ __('Hide Map') }}</button>
                    </div>
                    <!-- Hotel Reservation Area -->
                    <div class="chalet-reservation--area mb-100">
                        <form action="{{ route('hotels', app()->getLocale()) }}" method="get">
                            <div class="form-group mb-30">
                                <label for="checkInDate">{{ __('Date') }}</label>
                                <div class="">
                                    <div class="row no-gutters">
                                        <div class="col-6">
                                            <input type="date" value="{{Request::get('checkinDate')}}" class="input-small form-control" id="checkInDate" name="checkinDate" placeholder="Check In">
                                        </div>
                                        <div class="col-6">
                                            <input type="date" value="{{Request::get('checkoutDate')}}" class="input-small form-control" name="checkoutDate" placeholder="Check Out">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 mb-30">
                                    <label for="guests">{{ __('Guests') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="guests" id="guests" class="form-select" size="5">
                                                <option value="" selected="{{Request::get('guests') == ''}}">Guests</option>
                                                @for($i = 1; $i < 4; $i++)
                                                    @if(Request::get('guests') == $i)
                                                    <option value="{{$i}}" selected>From {{$i}} - To {{$i+1}}</option>
                                                    @else
                                                    <option value="{{$i}}">From {{$i}} - To {{$i+1}}</option>
                                                    @endif
                                                @endfor
                                                @if(Request::get('guests') == '4')
                                                    <option value="{{$i}}" selected>From 4 - More</option>
                                                    @else
                                                    <option value="{{$i}}">From 4 - More</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6 mb-30">
                                    <label for="guests">{{ __('Stars') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="stars" id="stars" class="form-select" size="5">
                                                <option value="" selected="{{Request::get('stars') == ''}}">Stars</option>
                                                @for($i = 1; $i < 5; $i++)
                                                    @if(Request::get('stars') == $i)
                                                    <option value="{{$i}}" selected>From {{$i}} - To {{$i+1}}</option>
                                                    @else
                                                    <option value="{{$i}}">From {{$i}} - To {{$i+1}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-50">
                                <div class="slider-range">
                                    <div class="mb-2" id="range-price"><strong>{{ __('Price') }} </strong> ₪ 0 - ₪ 3000</div>
                                    <div id="slider-range-price" data-min="0" data-max="3000" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="{{Request::get('price_min') ? Request::get('price_min') : 0}}" data-value-max="{{Request::get('price_min') ? Request::get('price_max') : 3000}}" data-label-result="Max Price: ">
                                        <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                        <input id="price_min" value="{{Request::get('price_min') ? Request::get('price_min') : '0'}}" name="price_min" hidden>
                                        <input id="price_max" value="{{Request::get('price_max') ? Request::get('price_max') : '3000'}}" name="price_max" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn roberto-btn w-100">{{ __('Check Availability') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rooms Area End -->

    <!-- Call To Action Area Start -->
    <section class="roberto-cta-area">
        <div class="container">
            <div class="cta-content bg-img bg-overlay jarallax" style="background-image: url('{{ asset('img/bg-img/1.jpg')}}');">
                <div class="row align-items-center">
                    <div class="col-12 col-md-7">
                        <div class="cta-text mb-50">
                            <h2>Contact us now!</h2>
                            <h6>Contact (+12) 345-678-9999 to book directly or for advice</h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 text-right">
                        <a href="#" class="btn roberto-btn mb-50">Contact Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action Area End -->

    <!-- Partner Area Start -->
    <div class="partner-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="partner-logo-content d-flex align-items-center justify-content-between wow fadeInUp" data-wow-delay="300ms">
                        <!-- Single Partner Logo -->
                        <a href="#" class="partner-logo"><img src="{{ asset('img/core-img/p1.png') }}" alt=""></a>
                        <!-- Single Partner Logo -->
                        <a href="#" class="partner-logo"><img src="{{ asset('img/core-img/p2.png') }}" alt=""></a>
                        <!-- Single Partner Logo -->
                        <a href="#" class="partner-logo"><img src="{{ asset('img/core-img/p3.png') }}" alt=""></a>
                        <!-- Single Partner Logo -->
                        <a href="#" class="partner-logo"><img src="{{ asset('img/core-img/p4.png') }}" alt=""></a>
                        <!-- Single Partner Logo -->
                        <a href="#" class="partner-logo"><img src="{{ asset('img/core-img/p5.png') }}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner Area End -->


@endsection

@section('script')
    <script>
        $(function() {
            // Get the slider element
            var slider = $("#slider-range-price");

            var inputMinVal = $("#price_min").val();
            var inputMaxVal = $("#price_max").val();

            // Set up the initial minimum and maximum values
            var minValue = slider.slider("option", "min");
            var maxValue = slider.slider("option", "max");

            // Display the initial maximum value
            if(inputMinVal != null || inputMaxVal != null)
                $("#range-price").text("{{ __('Price') }} ₪ " + inputMinVal + " - ₪ " + inputMaxVal);
            else
                $("#range-price").text("{{ __('Price') }} ₪ " + minValue + " - ₪ " + maxValue);

            // Event handler for slider change
            slider.on("slide change", function(event, ui) {
                // Retrieve the new maximum value
                var newMinValue = ui.values[0];
                var newMaxValue = ui.values[1];

                // Update the display with the new minimum and maximum values
                $("#range-price").text("{{ __('Price') }} ₪ " + newMinValue + " - ₪ " + newMaxValue);

                $("#price_min").val(newMinValue);
                $("#price_max").val(newMaxValue);
            });
        });

    </script>
    @section('script')

    <script>
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
    </script>
@stop
@stop