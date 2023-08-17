@extends('site.layouts.layout')

@section('content')


    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('{{ asset('img/bg-img/6.jpg')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ __('Restaurants') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Restaurants') }}</li>
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
            <div class="row">
                <div class="col-12 col-lg-8">
                    <!-- Single Room Area -->
                    @foreach($restaurents as $restaurent)
                    <div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Room Thumbnail -->
                        @php
                            $Imageslist = explode(",", $restaurent->photos);
                        @endphp
                        <div class="room-thumbnail">
                            <a href="{{ route('restaurant', [app()->getLocale(), $restaurent->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests')]) }}">
                                <img src="{{ asset('/images/Restaurents/' . $restaurent->id . '/'.$Imageslist[0]) }}" alt="">
                            </a>
                        </div>
                        <!-- Room Content -->
                        <div class="room-content">
                            <a href="{{ route('restaurant', [app()->getLocale(), $restaurent->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests')]) }}">
                                <h2>{{$restaurent->name}}</h2>
                            </a>
                            <div class="row justify-content-center">
                                <div class="col-7">
                                    <div class="d-flex flex-row">
                                        <h6><i class="fa fa-map-marker"></i> {{$restaurent->address}}</h6>
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
                                        <a href="{{ route('restaurant', [app()->getLocale(), $restaurent->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')]) }}" class="btn view-detail-btn">{{ __('View Details') }} <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="row mt-3">
                        {{ $restaurents->appends(request()->except('page'))->links('site.paginationLinks') }}
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <!-- restaurent Reservation Area -->
                    <div class="restaurent-reservation--area mb-100">
                        <form action="{{ route('restaurents', [app()->getLocale()]) }}" method="get">
                            <div class="form-group mb-30">
                                <label for="checkInDate">{{ __('Date') }}</label>
                                <div class="">
                                    <div class="row no-gutters">
                                        <div class="col-6">
                                            <input type="datetime-local" value="{{Request::get('checkinDate')}}" class="input-small form-control" id="checkInDate" name="checkinDate" placeholder="Check In">
                                        </div>
                                        <div class="col-6">
                                            <input type="datetime-local" value="{{Request::get('checkoutDate')}}" class="input-small form-control" name="checkoutDate" placeholder="Check Out">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <label for="guests">{{ __('Guests') }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <select name="adults" id="guests" class="form-control">
                                            <option value="adults">Adults</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                        </select>
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
@stop