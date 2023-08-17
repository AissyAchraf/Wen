@extends('site.layouts.layout')

@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="{{ asset('js/payment.js') }}"></script>

<div class="container mb-50 mt-50">

    <!-- Show messages -->
		@if(Session::has("message") && Session::get("message") && Session::get("message") == 'failed')			
			<div class="alert alert-danger">
			  @php 
          echo "Error : Payment failed!"; 
          Session::put("message", '');
			  @endphp
			</div>
		   
		@elseif (Session::get("message") && Session::get("message"))
			<div class="alert alert-success">
			  @php 
          echo Session::get("message"); 
          Session::put("message", '');
			  @endphp
			</div>
    @endif
		<!-- End Show messages -->

    <h4>{{$facilitieData->name}}</h4>
    @if(Session::has('reservation_data'))
        <p>Reservation staps</p>
        <div class="row mb-2">
            <label class="mr-5 ml-5">
                <input type="radio" name="payment" value="enabled" id="enableForm" checked> Due right now
            </label>
            <label>
                <input type="radio" name="payment" value="disabled" id="disableForm"> Due at proparty
            </label>
        </div>
        
        <!--Payment Card 5-->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12">
            <!-- <div class="col-md-6">   -->
                
                <span>Payment Method</span>
                <div class="card">
                  <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header p-0" id="headingTwo">
                        <h2 class="mb-0">
                          <button class="btn btn-light btn-block text-left collapsed p-3 rounded-0 border-bottom-custom" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <div class="d-flex align-items-center justify-content-between">
                              <span>Paypal</span>
                              <img src="{{ asset('/img/logos/paypal.png') }}" width="30">
                            </div>
                          </button>
                        </h2>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="payment-card-body">
                            <form action="" id="paypalPaymentForm">
                                <input type="text" class="payment-form-control" placeholder="Paypal email">
                                <p></p>
                                <button class="btn btn-primary px-5 free-button mb-3 float-right">Pay</button>
                            </form>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header p-0">
                        <h2 class="mb-0">
                          <button class="btn btn-light btn-block text-left p-3 rounded-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <div class="d-flex align-items-center justify-content-between">
                              <span>Credit card</span>
                              <div class="icons">
                                <img src="{{ asset('/img/logos/master.png') }}" width="30">
                                <img src="{{ asset('/img/logos/visa.png') }}" width="30">
                              </div>
                            </div>
                          </button>
                        </h2>
                      </div>

                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body payment-card-body">
                        <form action="{{ route('process', app()->getLocale()) }}" id="cardsPaymentForm" method="POST">
                          @csrf
                          <span class="text-muted certificate-text"> <span class="text-danger">*</span> required fields</span>
                          <p></p>
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

                          <span class="font-weight-normal payment-card-text">Card Number <span class="text-danger">*</span></span>
                          <div class="payment-input mb-3">
                            <i class="fa fa-credit-card"></i>
                            <input type="text" class="payment-form-control" placeholder="0000 0000 0000 0000"
                            name="cardNumber" id="cardNumber" maxlength="20" onkeypress="">
                            <span id="errorCardNumber" class="text-danger"></span>
                          </div> 

                          <div class="row mt-3 mb-3">
                            <div class="col-md-3">
                              <span class="font-weight-normal payment-card-text">Expiry Month <span class="text-danger">*</span></span>
                              <div class="payment-input">
                                <i class="fa fa-calendar"></i>
                                <input type="text" name="cardExpMonth" id="cardExpMonth" class="payment-form-control" placeholder="MM"
                                maxlength="2" onkeypress="return validateNumber(event);">
                                <span id="errorCardExpMonth" class="text-danger"></span>
                              </div> 
                            </div>
                            <div class="col-md-3">
                              <span class="font-weight-normal payment-card-text">Expiry Year <span class="text-danger">*</span></span>
                              <div class="payment-input">
                                <i class="fa fa-calendar"></i>
                                <input type="text" name="cardExpYear" id="cardExpYear" class="payment-form-control" placeholder="YYYY"
                                maxlength="4" onkeypress="return validateNumber(event);">
                                <span id="errorCardExpYear" class="text-danger"></span>
                              </div> 
                            </div>
                            <div class="col-md-6">
                              <span class="font-weight-normal payment-card-text">CVC/CVV <span class="text-danger">*</span></span>
                              <div class="payment-input">
                                <i class="fa fa-lock"></i>
                                <input type="text" name="cardCVC" id="cardCVC" class="payment-form-control" placeholder="000"
                                maxlength="3" onkeypress="return validateNumber(event);">
                                <span id="errorCardCvc" class="text-danger"></span>
                              </div> 
                            </div>
                          </div>
                          <span class="text-muted certificate-text"><i class="fa fa-lock"></i> Your transaction is secured with ssl certificate</span>
                          <p></p>
                          <input type="button" name="payNow" id="payNow" value="Pay Now" class="btn btn-primary px-5 free-button mb-3 float-right" onclick="stripePay(event)"/>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <div class="col-lg-5 col-md-12 mt-4">
                <div class="card profile-card-5">
                    <div class="card-img-block">
                        @php
                            $ImagesList = explode(',', $facilitieData->photos);
                        @endphp
                        <img class="card-img-top" src="{{ asset('/images/'.$facilitieType.'s/'.$facilitieData->id.'/'.$ImagesList[0]) }}" alt="Card image cap">
                    </div>
                    <div class="card-body pt-0">
                      <div class="d-flex justify-content-between">
                        <span class="bg-secondary rounded px-3 py-2 mb-2 mt-2 text-white">
                          {{$facilitieType}}
                        </span>
                        <!-- <br> -->
                        <!-- <a class="bg-danger rounded text-white px-3 py-2 my-auto"><i class="fa fa-trash fa-lg"></i> Cancel</a> -->
                      
                      </div>
                    
                    <h5 class="card-title mt-3">{{$facilitieData->name}}</h5>
                    <div class="border rounded py-2 px-3 mb-3">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-dark"><small>Check-in</small></span>
                            <span class="text-dark">{{$checkin}}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-dark"><small>Check-out</small></span>
                            <span class="text-dark">{{$checkout}}</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark" id="numberOfNights">{{$bookingDetails}}</span>
                        <span class="text-dark">₪ <span id="pricePerNights">{{$totalPrice}}</span></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark" id="taxesType">Taxes & fees</span>
                        <span class="text-dark">₪ <span id="taxesPrice">0</span></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-dark">Cleaning fee Due at property</span>
                        <span class="text-dark">₪ <span id="cleaningPrice">0</span></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-dark" id="total">Total</span>
                        <h4 class="text-dark">₪ <span id="totalPrice">{{$totalPrice}}</span></h4>
                    </div>
                    <a href="#">Have a promo code?</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2 ml-5">
            <p class="mt-3">Your agreement is with <a href="#">{{$facilitieData->name}}</a>.</p>
            <small>Terms of Booking By clicking "Pay", you agree you have read and accept our Terms and Conditions , Privacy Policy and Government Travel Advice.</small>
        </div>
        
    @else
        <p>No reservation data found!</p>
    @endif
</div>

@endsection

@section('script')

<script>
  // Get references to the radio buttons and the form
  const enableFormRadio = document.querySelector('input[value="enabled"]');
  const disableFormRadio = document.querySelector('input[value="disabled"]');
  const form = document.getElementById('cardsPaymentForm');
  const form2 = document.getElementById('paypalPaymentForm');

  // Add event listeners to the radio buttons
  enableFormRadio.addEventListener('change', function() {
    toggleFormElements(true); // Enable the form
    form.style.opacity = '1'; // Set full opacity
    form2.style.opacity = '1';
  });

  disableFormRadio.addEventListener('change', function() {
    toggleFormElements(false); // Disable the form
    form.style.opacity = '0.5'; // Reduce the opacity
    form2.style.opacity = '0.5'; // Reduce the opacity
  });

  function toggleFormElements(enable) {
    const formElements = form.elements;
    const formElements2 = form2.elements;
    for (let i = 0; i < formElements.length; i++) {
      formElements[i].disabled = !enable;
    }
    for (let i = 0; i < formElements2.length; i++) {
      formElements2[i].disabled = !enable;
    }
  }
</script>

@stop