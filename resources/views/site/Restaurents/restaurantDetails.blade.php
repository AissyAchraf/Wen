@extends('site.layouts.layout')

@section('content')

    @php
        $Imageslist = explode(",", $restaurant->photos);
    @endphp
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('{{ asset('/images/Restaurents/' . $restaurant->id . '/'.$Imageslist[0]) }}');">
        <div class="container h-100">
            <div class="row h-100 align-items-end">
                <div class="col-12">
                    <div class="breadcrumb-content d-flex align-items-center justify-content-between pb-5">
                        <h2 class="room-title">{{ $restaurant->name }}</h2>
                        <!-- <h2 class="room-price">$180 <span>/ Per Night</span></h2> -->
                        @if(Auth::user() && Auth::user()->id == $restaurant->user_manager)
                        <div class="row align-items-end justify-content-betwen">
                            <form class="mr-2" action="{{ route('edit-restaurant', [app()->getLocale(), $restaurant->id]) }}">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-pen"></i> Update Restaurant Information</button>
                            </form>
                            <form action="{{ route('restaurant-tables', [app()->getLocale(), $restaurant->id]) }}">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-room"></i> Tables List</button>
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
            @if (Session::get("reservation_sent") && Session::get("reservation_sent"))
                <div class="alert alert-success">
                @php 
                    echo Session::get("reservation_sent"); 
                    Session::put("reservation_sent", '');
                @endphp
                </div>
            @endif
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
                                            <img src="{{ asset('/images/Restaurents/' . $restaurant->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </div>
                                        @else
                                        <div class="carousel-item">
                                            <img src="{{ asset('/images/Restaurents/' . $restaurant->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </div>
                                        @endif
                                    @endforeach
                                </div>

                                <ol class="carousel-indicators">
                                    @foreach(array_slice($Imageslist, 1) as $image)
                                        @if($loop->index == 0)
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}" class="active">
                                            <img src="{{ asset('/images/Restaurents/' . $restaurant->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </li>
                                        @else
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}">
                                            <img src="{{ asset('/images/Restaurents/' . $restaurant->id . '/'.$image) }}" class="d-block w-100" alt="">
                                        </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                        <!-- Room Features -->
                        <div class="row mb-3">
                            <div class="col">
                                <h2>{{ $restaurant->name }}</h2>
                                <p><i class="fa fa-map-marker"></i> {{ $restaurant->address }}</p>
                                <p>Cuisine : {{ $restaurant->cuisine }}</p>
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
                        
                        <p>{{ $restaurant->description }}</p>

                    </div>

                    <div class="rooms mb-50">
                        <h4>{{ __('Choose your table') }}</h4>

                        <div class="row">
                            @foreach($restaurant->tables as $table)
                            <div class="col-md-1 col-lg-6 mb-3">
                                <div class="card h-100">
                                @php
                                    $tableImages = explode(",", $table->photos);
                                @endphp
                                <a href="#" class="text-primary" data-toggle="modal" data-target=".table-modal-{{$table->id}}">
                                    <img src="{{ asset('/images/Tables/' . $table->id . '/'.$tableImages[0]) }}" class="card-img-top h-100"
                                    alt="Table Image" />
                                </a>

                                <div class="ml-2" style="position:absolute;">
                                    <div class="d-flex justify-content-end align-items-end h-100">
                                        <h5><span class="badge pt-2 ms-3 mt-3 text-white" style="background-color: rgba(0, 0, 0, 0.4);">
                                        <i class="fa fa-images"></i> @php echo count($tableImages); @endphp</span></h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Table number : {{$table->number}}</h5>
                                    <p class="card-text">
                                        <ul>
                                            <li><i class="fa fa-user"></i> {{$table->capacity}} {{ __('persons') }}</li>
                                        </ul>
                                        <br>
                                        <p><a href="#" class="text-primary" data-toggle="modal" data-target=".table-modal-{{$table->id}}">{{ __('More details') }} ></a></p>
                                        
                                        <div class="breadcrumb-content d-flex">
                                            <h5 class="room-price">₪ {{$table->price}}</h5><span> / {{ __('hour') }}</span>
                                        </div>
                                        @if(Session::has('number_hours'))
                                        <p>Total ₪ {{ $table->price*Session::get('number_hours') }} includes taxes & fees</p>
                                        @endif
                                        @if(Auth::check())
                                        <button data-toggle="modal" data-target=".reservation-modal-{{ $table->id }}" class="btn btn-primary float-right">{{ __('Reserve') }}</button>
                                        @else
                                        <a href="{{ route('login', app()->getLocale()) }}" class="btn btn-primary float-right">{{ __('Reserve') }}</a>
                                        @endif
                                    </p>
                                </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mt-3">
                            {{ $restaurant->tables->appends(request()->except('page'))->links('site.paginationLinks') }}
                        </div>
                    </div>

                    <!-- Room Review -->
                    <div class="room-review-area mb-100">
                        <h4>{{ __('Restaurant Review') }}</h4>

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
                    <!-- Restaurant Reservation Area -->
                    <div id="map" data-latitude="{{ $restaurant->latitude }}" data-longitude="{{ $restaurant->longitude }}" style="height:300px;width:100%;"></div>
                    <p></p>
                    <h4>{{ __('Choose your date') }}</h4>
                    @error('notAvailableMessage')
                        <div class="alert alert-danger"><small><i class="fa-solid fa-triangle-exclamation"></i> {{ __($message) }}</small></div>
                    @enderror
                        <form action="{{ route('restaurant', [app()->getLocale(), $restaurant->id]) }}" method="get">
                            @csrf
                            <div class="form-group mb-30">
                                <label for="checkInDate">{{ __('Date') }}</label>
                                <div class="">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="date" value="{{ old('date') != null ? old('date') : Request::get('date')}}" class="input-small form-control @error('date') border-danger @enderror" id="date" name="date" placeholder="Date">
                                        </div>
                                    </div>
                                </div>
                                @error('date')
                                    <span class="text-danger"><small>{{ __($message) }}</small></span>
                                @enderror
                            </div>
                            <div class="form-group mb-30">
                                
                                <div class="">
                                    <div class="row no-gutters">
                                        <div class="col-6">
                                            <label for="checkinHour">{{ __('From') }}</label>
                                            <input type="time" value="{{ old('checkinHour') != null ? old('checkinHour') : Request::get('checkinHour')}}" class="input-small form-control @error('checkinHour') border-danger @enderror" id="checkinHour" name="checkinHour" placeholder="Check-in Hour">
                                            @error('checkinHour')
                                                <span class="text-danger"><small>{{ __($message) }}</small></span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="checkinHour">{{ __('To') }}</label>
                                            <input type="time" value="{{ old('checkoutHour') != null ? old('checkoutHour') : Request::get('checkoutHour')}}" class="input-small form-control @error('checkoutHour') border-danger @enderror" id="checkoutHour" name="checkoutHour" placeholder="Check-out Hour">
                                            @error('checkoutHour')
                                                <span class="text-danger"><small>{{ __($message) }}</small></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group mb-30">
                                <label for="guests">{{ __('Guests') }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <select name="guests" id="guests" class="form-select y-scroll @error('guests') border-danger @enderror" size="5">
                                            <option value="" selected="{{ old('guests') == '' || Request::get('guests') == ''}}">Guests</option>
                                            @for($i = 1; $i <= 10; $i++)
                                                @if( old('guests') == $i || Request::get('guests') == $i)
                                                <option value="{{$i}}" selected>{{$i}}</option>
                                                @else
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endif
                                            @endfor
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
                            <a href="{{ route('start-conversation', ['id'=>$restaurant->user_manager]) }}" class="btn view-detail-btn mb-3">Start Conversation <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
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
    @foreach($restaurant->tables as $table)
    @php
        $ImagesTablelist = explode(",", $table->photos);
    @endphp
    <div class="modal fade table-modal-{{$table->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Table informations') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="room-thumbnail-slides mb-20">
                <div id="room-thumbnail--slide" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($ImagesTablelist as $image)
                            @if($loop->index == 0)
                            <div class="carousel-item active">
                                <img src="{{ asset('/images/Tables/' . $table->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </div>
                            @else
                            <div class="carousel-item">
                                <img src="{{ asset('/images/Tables/' . $table->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <ol class="carousel-indicators">
                        @foreach($ImagesTablelist as $image)
                            @if($loop->index == 0)
                            <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}" class="active">
                                <img src="{{ asset('/images/Tables/' . $table->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </li>
                            @else
                            <li data-target="#room-thumbnail--slide" data-slide-to="{{$loop->index}}">
                                <img src="{{ asset('/images/Tables/' . $table->id . '/'.$image) }}" class="d-block w-100" alt="">
                            </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
            <h5 class="card-title">{{$table->number}}</h5>
            <ul>
                <li><i class="fa fa-user"></i> {{$table->capacity}} {{ __('persons') }}</li>
            </ul>
            <p></p>
            <p>{{ __('Reviews') }} 4.6/5</p>
            <div class="breadcrumb-content d-flex">
                <h5 class="room-price">₪ {{$table->price}}</h5><span> / {{ __('hour') }}</span>
            </div>
        
        </div>
        <div class="modal-footer">
            @if(Auth::check())
            <button data-toggle="modal" data-target=".reservation-modal-{{ $table->id }}" class="btn btn-primary float-right">{{ __('Reserve') }}</button>
            @else
            <a href="{{ route('login', app()->getLocale()) }}" class="btn btn-primary float-right">{{ __('Reserve') }}</a>
            @endif
        </div>
        </div>
    </div>
    </div>
    @endforeach

    @foreach($restaurant->tables as $table)
    <div class="modal fade reservation-modal-{{$table->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Reservation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('start-conversation', ['id'=>$restaurant->user_manager]) }}" class="button btn w-100 text-center rounded border">
                                    <img src="{{ asset('/img/core-img/icon6.png') }}" alt="Chat with the restaurant"/>
                                    <span class="text-reberto">Book</span> By Message
                                </a>
                            </div>
                        </div>
                        <hr>
                        <h4>Pending Reservation Request</h4>
                        <div class="row mt-3">
                            <div class="col-12">
                                <form action="{{ route('processTableReservation', [app()->getLocale()]) }}" id="cardsPaymentForm" method="POST">
                                    @csrf
                                    <span class="text-muted certificate-text"> <span class="text-danger">*</span> required fields</span>
                                    <p></p>
                                    <input type="text" name="table_id" value="{{ $table->id }}}" hidden>
                                    <input type="date" name="date" value="{{ Request::get('date') }}" hidden>
                                    <input type="time" name="checkinHour" value="{{ Request::get('checkinHour') }}" hidden>
                                    <input type="time" name="checkoutHour" value="{{ Request::get('checkinHour') }}" hidden>
                                    <input type="text" name="guests" value="{{ Request::get('guests') }}" hidden>

                                    <span class="font-weight-normal payment-card-text">Full Name <span class="text-danger">*</span></span>
                                    <div class="mb-3">
                                        <input type="text" name="customerName" id="customerName" class="payment-form-control" placeholder="Full Name">
                                        <span id="errorCustomerName" class="text-danger"></span>
                                    </div>

                                    <span class="font-weight-normal payment-card-text">Email Address <span class="text-danger">*</span></span>
                                    <div class="mb-3">
                                        <input type="text" name="emailAddress" id="emailAddress" class="payment-form-control" placeholder="Email Address">
                                        <span id="errorEmailAddress" class="text-danger"></span>
                                    </div>

                                    <span class="font-weight-normal payment-card-text">Phone <span class="text-danger">*</span></span>
                                    <div class="mb-3">
                                        <input type="text" name="phone" id="phone" class="payment-form-control" placeholder="Phone">
                                        <span id="errorPhone" class="text-danger"></span>
                                    </div>

                                    <button class="button btn w-100 text-center rounded border">
                                        <i class="fa fa-paper-plane"></i>
                                        {{ __('Send') }}
                                    </button>
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-secondary float-right">{{ __('Cancel') }}</a>
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

        var map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: "© <a href='https://www.openstreetmap.org/?mlat={{$restaurant->latitude}}&mlon={{$restaurant->longitude}}#map=19/{{$restaurant->latitude}}/{{$restaurant->longitude}}' target='_blank'>OpenStreetMap</a>",
        }).addTo(map);
        L.marker([latitude, longitude]).addTo(map);

        map.dragging.disable();
        map.touchZoom.disable();
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        if (map.tap) map.tap.disable();
    </script>
    @stop