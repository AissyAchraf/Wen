@extends('site.layouts.layout')

@section('content')

    @php
        $Imageslist = explode(",", $chalet->photos);
    @endphp
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('{{ asset('/images/chalets/' . $chalet->id . '/'.$Imageslist[0]) }}');">
        <div class="container h-100">
            <div class="row h-100 align-items-end">
                <div class="col-12">
                    <div class="breadcrumb-content d-flex align-items-center justify-content-between pb-5">
                        <h2 class="room-title">{{ $chalet->name }}</h2>
                        @if(Auth::user() && Auth::user()->id == $chalet->user_manager)
                        <div class="row align-items-end justify-content-betwen">
                            <form class="mr-2" action="{{ route('edit-chalet', [app()->getLocale(), $chalet->id]) }}">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-pen"></i> Update Chalet Information</button>
                            </form>
                        </div>
                        @endif
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
                    <!-- Single Room Details Area -->
                    <div class="single-room-details-area mb-50">
                        <!-- Room Thumbnail Slides -->
                        <div class="room-thumbnail-slides mb-50">
                            <div id="room-thumbnail--slide" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($Imageslist as $image)
                                        @if($loop->index == 0)
                                        <div class="carousel-item h-100 active">
                                            <img src="{{ asset('/images/chalets/' . $chalet->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </div>
                                        @else
                                        <div class="carousel-item h-100">
                                            <img src="{{ asset('/images/chalets/' . $chalet->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </div>
                                        @endif
                                    @endforeach
                                </div>

                                <ol class="carousel-indicators">
                                    @foreach($Imageslist as $image)
                                        @if($loop->index == 0)
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}" class="active">
                                            <img src="{{ asset('/images/Chalets/' . $chalet->id . '/'.$image) }}" class="d-block h-100" alt="">
                                        </li>
                                        @else
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}">
                                            <img src="{{ asset('/images/Chalets/' . $chalet->id . '/'.$image) }}" class="d-block h-100" alt="">
                                        </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                        <!-- Room Features -->
                        <div class="row mb-3">
                            <div class="col">
                                <h2>{{ $chalet->name }}</h2>
                                <p><i class="fa fa-map-marker"></i> {{ $chalet->address }}</p>
                            </div>
                            <div class="col">
                                <div class="row justify-content-end">
                                    <div class="bg-success p-2 text-white rounded ml-5">4.8 <span style="font-size:10px;">/5</span></div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="ml-5">
                                        <p>15 {{ __('reviews') }}</p>
                                        <a href="#" class="text-primary">{{ __('See all reviews') }} ></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <p style="white-space: pre-wrap;">{{ $chalet->description }}</p>

                    </div>

                    <!-- Services -->
                    <div class="room-service mb-50">
                        <h4>{{ __('Popular amenities') }}</h4>
                        <!-- @php
                            $amenitiesList = explode(",", $chalet->amenities);
                        @endphp -->
                        <ul>
                            <li><i class="fa fa-snowflake-o"></i> Air Conditioning</li>
                            <li><i class="fa-solid fa-person-swimming"></i> Pool</li>
                            <li><i class="fa fa-car"></i> Free parking</li>
                            <li><i class="fa fa-wifi"></i> Free Wifi</li>
                            <li><i class="fa fa-refrigerator"></i> Refrigerator</li>
                            <li><i class="fa-solid fa-kitchen-set"></i> Kitchenette</li>
                        </ul>
                        <br>
                        <a href="#" class="text-primary">{{ __('See all') }} ></a>
                    </div>

                    <div class="mb-50">
                        <h4>{{ __('Space details') }}</h4>
                        <p></p>
                        <ul>
                            <li>
                                <i class="fa fa-check"></i> Bedroom 1 (2 king beds)
                            </li>
                            <li>
                                <i class="fa fa-check"></i> Kitchenette
                            </li>
                            <li>
                                <i class="fa fa-check"></i> Refrigerator
                            </li>
                        </ul>
                    </div>
                    <!-- Room Review -->
                    <div class="room-review-area mb-100">
                        <h4>{{ __('Chalet Review') }}</h4>

                        <!-- Single Review Area -->
                        <div class="single-room-review-area d-flex align-items-center">
                            <div class="reviwer-thumbnail">
                                <img src="img/bg-img/53.jpg" alt="">
                            </div>
                            <div class="reviwer-content">
                                <div class="reviwer-title-rating d-flex align-items-center justify-content-between">
                                    <div class="reviwer-title">
                                        <span>27 Aug 2019</span>
                                        <h6>Brandon Kelley</h6>
                                    </div>
                                    <div class="reviwer-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.</p>
                            </div>
                        </div>

                        <!-- Single Review Area -->
                        <div class="single-room-review-area d-flex align-items-center">
                            <div class="reviwer-thumbnail">
                                <img src="img/bg-img/54.jpg" alt="">
                            </div>
                            <div class="reviwer-content">
                                <div class="reviwer-title-rating d-flex align-items-center justify-content-between">
                                    <div class="reviwer-title">
                                        <span>27 Aug 2019</span>
                                        <h6>Sounron Masha</h6>
                                    </div>
                                    <div class="reviwer-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.</p>
                            </div>
                        </div>

                        <!-- Single Review Area -->
                        <div class="single-room-review-area d-flex align-items-center">
                            <div class="reviwer-thumbnail">
                                <img src="img/bg-img/55.jpg" alt="">
                            </div>
                            <div class="reviwer-content">
                                <div class="reviwer-title-rating d-flex align-items-center justify-content-between">
                                    <div class="reviwer-title">
                                        <span>27 Aug 2019</span>
                                        <h6>Amada Lyly</h6>
                                    </div>
                                    <div class="reviwer-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <!-- chalet Reservation Area -->
                    <div id="map" data-latitude="{{ $chalet->latitude }}" data-longitude="{{ $chalet->longitude }}" style="height:300px;width:100%;" class="mb-50"></div>
                    <div class="chalet-reservation--area mb-100">
                    <h4>{{ __('Choose your date') }}</h4>
                    @error('notAvailableMessage')
                        <div class="alert alert-danger"><small><i class="fa-solid fa-triangle-exclamation"></i> {{ __($message) }}</small></div>
                    @enderror
                        <form action="{{ route('chalet', [app()->getLocale(), $chalet->id]) }}" method="get">
                            @csrf
                            <div class="form-group mb-30">
                                <label for="checkInDate">{{ __('Date') }}</label>
                                <div class="">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="date" value="{{ old('date') ? old('date') : Request::get('date')}}" class="input-small form-control" id="date" name="date" placeholder="Check In">
                                            @error('date')
                                                <span class="text-danger"><small>{{ __($message) }}</small></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group mb-30">
                                        <label for="checkInDate">{{ __('Hour') }}</label>
                                        <div class="">
                                            <div class="row no-gutters">
                                                <div class="col-12">
                                                    <input type="time" value="{{ old('checkinHour') ? old('checkinHour') : Request::get('checkinHour')}}" class="input-small form-control" id="checkinHour" name="checkinHour" placeholder="Check In Hour">
                                                    @error('checkinHour')
                                                        <span class="text-danger"><small>{{ __($message) }}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group mb-30">
                                        <label for="checkInDate">{{ __('Interval of 12 hours') }}</label>
                                        <div class="">
                                            <div class="row no-gutters">
                                                <div class="col-12">
                                                    <input type="number" value="{{ old('booking_intervals') ? old('booking_intervals') : Request::get('booking_intervals')}}" class="input-small form-control" id="booking_intervals" name="booking_intervals" placeholder="Number of 12-hour intervals">
                                                    @error('booking_intervals')
                                                        <span class="text-danger"><small>{{ __($message) }}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn roberto-btn w-100">{{ __('Check Availability') }}</button>
                            </div>
                        </form>

                        <!-- Contact Card -->
                        <div class="card text-center pt-4 px-2 mb-3">
                            <img src="{{ asset('/img/core-img/envelope.png') }}" class="mx-auto mb-2" width="64px" alt="">
                            <h4><span class="text-reberto">Book</span> or ask Questions</h4>
                            <a href="{{ route('start-conversation', ['id'=>$chalet->user_manager]) }}" class="btn view-detail-btn mb-3">Start Conversation <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            <small class="mb-3">Monday to Friday 9.00am - 7.30pm</small>
                        </div>
                        <!-- Contact Card end -->

                        @if(Request::get('date') != null && Request::get('checkinHour') != null && Request::get('booking_intervals') != null && $errors->isEmpty())
                            @php
                                $reservation_data = Session()->get('reservation_data');
                            @endphp
                        <div class="card">
                            <div class="card-body">
                                <div class="card-text">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-dark">{{ $reservation_data['bookingDetails'] }}</span>
                                        <span class="text-dark">₪ {{ $reservation_data['totalPrice'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-dark" id="taxesType">{{ __('Taxes & fees') }}</span>
                                        <span class="text-dark">₪ <span id="taxesPrice">0</span></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-dark">{{ __('Cleaning fee Due at property') }}</span>
                                        <span class="text-dark">₪ <span id="cleaningPrice">0</span></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-dark" id="total">{{ __('Total') }}</span>
                                        <span class="text-dark">₪ {{ $reservation_data['totalPrice'] }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('reserve', app()->getLocale()) }}" class="btn btn-primary w-100">{{ __('Reserve') }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rooms Area End -->

@endsection

@section('script')
    <script>
        const latitude = parseFloat(document.getElementById('map').getAttribute('data-latitude'));
        const longitude = parseFloat(document.getElementById('map').getAttribute('data-longitude'));
        console.log(latitude);
        var map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: "© <a href='https://www.openstreetmap.org/?mlat={{$chalet->latitude}}&mlon={{$chalet->longitude}}#map=16/{{$chalet->latitude}}/{{$chalet->longitude}}' target='_blank'>OpenStreetMap</a>",
        }).addTo(map);
        L.marker([latitude, longitude]).addTo(map);
        
        map.dragging.disable();
        map.touchZoom.disable();
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        if (map.tap) map.tap.disable();
    </script>
    <script>
        $(document).ready(function() {
            $('#bookingForm').on('submit', function(event) {
                const checkinDate = new Date($('#checkinDate').val());
                const checkoutDate = new Date($('#checkoutDate').val());
                const timeDifference = (checkoutDate - checkinDate) / (1000 * 60 * 60); // Difference in hours
                
                if (timeDifference % 12 !== 0) {
                event.preventDefault(); // Prevent form submission
                $('#errorText').show();
                }
            });
        });
    </script>
    @stop