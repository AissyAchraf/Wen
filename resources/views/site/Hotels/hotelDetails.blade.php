@extends('site.layouts.layout')

@section('content')

    @php
        $Imageslist = explode(",", $hotel->photos);
    @endphp
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('{{ asset('/images/Hotels/' . $hotel->id . '/'.$Imageslist[0]) }}');">
        <div class="container h-100">
            <div class="row h-100 align-items-end">
                <div class="col-12">
                    <div class="breadcrumb-content d-flex align-items-center justify-content-between pb-5">
                        <h2 class="room-title">{{ $hotel->name }}</h2>
                        <!-- <h2 class="room-price">$180 <span>/ Per Night</span></h2> -->
                        @if(Auth::user() && Auth::user()->id == $hotel->user_manager)
                        <div class="row align-items-end justify-content-betwen">
                            <form class="mr-2" action="{{ route('edit-hotel', [app()->getLocale(), $hotel->id]) }}">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-pen"></i> Update Hotel Information</button>
                            </form>
                            <form action="{{ route('hotel-rooms', [app()->getLocale(), $hotel->id]) }}">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-room"></i> Rooms List</button>
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
                                    @foreach(array_slice($Imageslist, 1) as $image)
                                        @if($loop->index == 0)
                                        <div class="carousel-item active">
                                            <img src="{{ asset('/images/Hotels/' . $hotel->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </div>
                                        @else
                                        <div class="carousel-item">
                                            <img src="{{ asset('/images/Hotels/' . $hotel->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </div>
                                        @endif
                                    @endforeach
                                </div>

                                <ol class="carousel-indicators">
                                    @foreach(array_slice($Imageslist, 1) as $image)
                                        @if($loop->index == 0)
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}" class="active">
                                            <img src="{{ asset('/images/Hotels/' . $hotel->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </li>
                                        @else
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}">
                                            <img src="{{ asset('/images/Hotels/' . $hotel->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                        <!-- Room Features -->
                        <div class="row mb-3">
                            <div class="col">
                                <h2>{{ $hotel->name }}</h2>
                                <p><i class="fa fa-map-marker"></i> {{ $hotel->address }}</p>
                                @for($i = 0; $i < $hotel->stars; $i++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                            </div>
                            <div class="col">
                                <div class="row justify-content-end">
                                    <div class="bg-success p-2 text-white rounded">4.8 <span style="font-size:10px;">/5</span></div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="ml-5">
                                        <p>15 {{ __('reviews') }}</p>
                                        <a href="#" class="text-primary">{{ __('See all reviews') }} ></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <p>{{ $hotel->description }}</p>

                    </div>

                    <!-- Services -->
                    <div class="room-service mb-50">
                        <h4>{{ __('Popular amenities') }}</h4>
                        @php
                            $amenitiesList = explode(",", $hotel->amenities);
                        @endphp
                        <ul>
                            <li><i class="fa fa-snowflake-o"></i> Air Conditioning</li>
                            <li><i class="fa-solid fa-person-swimming"></i> Pool</li>
                            <li><i class="fa fa-cutlery"></i> Restaurant</li>
                            <li><i class="fa fa-wifi"></i> Free Wifi</li>
                            <li><i class="fa fa-glass"></i> Bar</li>
                            <li><i class="fa-solid fa-dumbbell"></i> Gym</li>
                        </ul>
                        <br>
                        <a href="#" class="text-primary">{{ __('See all') }} ></a>
                    </div>

                    <div class="rooms mb-50">
                        <h4>{{ __('Choose your room') }}</h4>

                        <div class="row">
                            @foreach($hotel->rooms as $room)
                            <div class="col-md-1 col-lg-6 mb-3">
                                <div class="card h-100">
                                @php
                                    $roomImages = explode(",", $room->photos);
                                @endphp
                                <img src="{{ asset('/images/Rooms/' . $room->id . '/'.$roomImages[0]) }}" class="card-img-top h-100"
                                    alt="Room Image" />
                                <div class="ml-2" style="position:absolute;">
                                    <div class="d-flex justify-content-end align-items-end h-100">
                                        <h5><span class="badge pt-2 ms-3 mt-3 text-white" style="background-color: rgba(0, 0, 0, 0.4);">
                                        <i class="fa fa-images"></i> @php echo count($roomImages); @endphp</span></h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$room->room_type}}, {{$room->beds_type}}</h5>
                                    <p class="card-text">
                                        <ul>
                                            <li><i class="fa fa-square"></i> {{$room->surface}} {{ __('m') }}<sup>2</sup></li>
                                            <li><i class="fa fa-user"></i> {{$room->capacity}} {{ __('persons') }}</li>
                                            <li><i class="fa-solid fa-bed"></i> {{$room->beds_type}}</li>
                                        </ul>
                                        <br>
                                        <p><a href="#" class="text-primary" data-toggle="modal" data-target=".room-modal-{{$room->id}}">{{ __('More details') }} ></a></p>
                                        
                                        <div class="breadcrumb-content d-flex">
                                            <h5 class="room-price">₪ {{$room->price}}</h5><span> / {{ __('night') }}</span>
                                        </div>
                                        @if(Session::has('number_nights'))
                                        <p>Total ₪ {{ $room->price*Session::get('number_nights') }} includes taxes & fees</p>
                                        @endif
                                        <a href="{{ route('processRoomReservation', [app()->getLocale(), $room->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')]) }}" class="btn btn-primary float-right">{{ __('Reserve') }}</a>
                                    </p>
                                </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mt-3">
                            {{ $hotel->rooms->appends(request()->except('page'))->links('site.paginationLinks') }}
                        </div>
                    </div>

                    <!-- Room Review -->
                    <div class="room-review-area mb-100">
                        <h4>{{ __('Hotel Review') }}</h4>

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
                    <!-- Hotel Reservation Area -->
                    <div id="map" data-latitude="{{ $hotel->latitude }}" data-longitude="{{ $hotel->longitude }}" style="height:300px;width:100%;"></div>
                    <p></p>
                    <h4>{{ __('Choose your date') }}</h4>
                    @error('notAvailableMessage')
                        <div class="alert alert-danger"><small><i class="fa-solid fa-triangle-exclamation"></i> {{ __($message) }}</small></div>
                    @enderror
                        <form action="{{ route('hotel', [app()->getLocale(), $hotel->id]) }}" method="get">
                            @csrf
                            <div class="form-group mb-30">
                                <label for="checkInDate">{{ __('Date') }}</label>
                                <div class="">
                                    <div class="row no-gutters">
                                        <div class="col-6">
                                            <input type="date" value="{{ old('checkinDate') != null ? old('checkinDate') : Request::get('checkinDate')}}" class="input-small form-control @error('checkinDate') border-danger @enderror" id="checkInDate" name="checkinDate" placeholder="Check In">
                                        </div>
                                        <div class="col-6">
                                            <input type="date" value="{{ old('checkoutDate') != null ? old('checkoutDate') : Request::get('checkoutDate')}}" class="input-small form-control @error('checkoutDate') border-danger @enderror" id="checkOutDate" name="checkoutDate" placeholder="Check Out">
                                        </div>
                                    </div>
                                </div>
                                @error('checkinDate')
                                    <span class="text-danger"><small>{{ __($message) }}</small></span>
                                @enderror
                                @error('checkoutDate')
                                    <span class="text-danger"><small>{{ __($message) }}</small></span>
                                @enderror
                            </div>
                            <div class="form-group mb-30">
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
                                @error('guests')
                                    <span class="text-danger"><small>{{ __($message) }}</small></span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn roberto-btn w-100">{{ __('Check Availability') }}</button>
                            </div>
                        </form>

                        <!-- Contact Card -->
                        <div class="card text-center pt-4 px-2 mb-3">
                            <img src="{{ asset('/img/core-img/envelope.png') }}" class="mx-auto mb-2" width="64px" alt="">
                            <h4><span class="text-reberto">Book</span> or ask Questions</h4>
                            <a href="{{ route('start-conversation', ['id'=>$hotel->user_manager]) }}" class="btn view-detail-btn mb-3">Start Conversation <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            <small class="mb-3">Monday to Friday 9.00am - 7.30pm</small>
                        </div>
                        <!-- Contact Card end -->

                        @if(Request::get('checkinDate') != null && Request::get('checkoutDate') != null && Request::get('guests') != null && $errors->isEmpty() && Session::has('reservation_data'))
                        <div class="card">
                            <div class="card-body">
                                <div class="card-text">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-dark" id="numberOfNights"></span>
                                        <span class="text-dark">₪ <span id="pricePerNights"></span></span>
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
                                        <span class="text-dark">₪ <span id="totalPrice">0</span></span>
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
    @foreach($hotel->rooms as $room)
    @php
        $ImagesRoomlist = explode(",", $room->photos);
    @endphp
    <div class="modal fade room-modal-{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Room informations') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="room-thumbnail-slides mb-20">
                <div id="room-thumbnail--slide" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($ImagesRoomlist as $image)
                            @if($loop->index == 0)
                            <div class="carousel-item active">
                                <img src="{{ asset('/images/Rooms/' . $room->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </div>
                            @else
                            <div class="carousel-item">
                                <img src="{{ asset('/images/Rooms/' . $room->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <ol class="carousel-indicators">
                        @foreach($ImagesRoomlist as $image)
                            @if($loop->index == 0)
                            <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}" class="active">
                                <img src="{{ asset('/images/Rooms/' . $room->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </li>
                            @else
                            <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}">
                                <img src="{{ asset('/images/Rooms/' . $room->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
            <h5 class="card-title">{{$room->room_type}}, {{$room->beds_type}}</h5>
            <ul>
                <li><i class="fa fa-square"></i> {{$room->surface}} {{ __('m') }}<sup>2</sup></li>
                <li><i class="fa fa-user"></i> {{$room->capacity}} {{ __('persons') }}</li>
                <li><i class="fa-solid fa-bed"></i> {{$room->beds_type}}</li>
            </ul>
            <p></p>
            <!-- <p><a href="#" class="text-primary" data-toggle="modal" data-target=".room-modal-{{$room->id}}">More details ></a></p> -->
            <p>{{ __('Reviews') }} 4.6/5</p>
            <div class="breadcrumb-content d-flex">
                <h5 class="room-price">₪ {{$room->price}}</h5><span> / {{ __('night') }}</span>
            </div>
            <h6>{{ __('Room amenities') }}</h6>
            @php
                $roomAmenities = explode(",", $room->amenities);
            @endphp
            <ul>
                @foreach($roomAmenities as $a)
                <li><i class="fa fa-check"></i> {{$a}}</li>
                @endforeach
            </ul>
            <!-- <p class="text-black">{{$room->amenities ?? ''}}<p> -->
        </div>
        <div class="modal-footer">
            <a href="{{ route('processRoomReservation', [app()->getLocale(), $room->id, 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')]) }}" class="btn btn-primary float-right">{{ __('Reserve') }}</a>
        </div>
        </div>
    </div>
    </div>
    @endforeach
@endsection

@section('script')

    <script>
        const latitude = parseFloat(document.getElementById('map').getAttribute('data-latitude'));
        const longitude = parseFloat(document.getElementById('map').getAttribute('data-longitude'));
        console.log(latitude);
        var map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: "© <a href='https://www.openstreetmap.org/?mlat={{$hotel->latitude}}&mlon={{$hotel->longitude}}#map=16/{{$hotel->latitude}}/{{$hotel->longitude}}' target='_blank'>OpenStreetMap</a>",
        }).addTo(map);
        L.marker([latitude, longitude]).addTo(map);
        
        map.dragging.disable();
        map.touchZoom.disable();
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        if (map.tap) map.tap.disable();
    </script>
    @stop