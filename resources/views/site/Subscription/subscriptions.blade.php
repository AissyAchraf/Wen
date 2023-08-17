@extends('site.layouts.layout')

@section('content')

    <link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css"> 
    <section class="price_plan_area section_padding_130_80 pt-5" id="pricing">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-8 col-lg-6">
            <!-- Section Heading-->
            <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
              <h6>Pricing Plans</h6>
              <p>Choose your subscription plan</p>
              <div class="line"></div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <!-- Single Price Plan Area-->
          <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="single_price_plan active wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
              <div class="title">
                <h3>Basic</h3>
                <p>Limited benefits</p>
                <div class="line"></div>
              </div>
              <div class="price">
                <h4>$0</h4>
              </div>
              <div class="description">
                <p><i class="lni lni-checkmark-circle"></i>Duration: Lifelong</p>
                <p><i class="lni lni-checkmark-circle"></i>Property Listing Management</p>
                <p><i class="lni lni-checkmark-circle"></i>Booking Calendar</p>
                <p><i class="lni lni-checkmark-circle"></i>Payment Gateway Integration</p>
                <p><i class="lni lni-close"></i>Communication Platform</p>
                <p><i class="lni lni-close"></i>Reviews and Ratings Management</p>
                <p><i class="lni lni-close"></i>Promotional Tools</p>
              </div>
              <div class="button"><a class="btn btn-success btn-2" href="#">Get Started</a></div>
            </div>
          </div>
          <!-- Single Price Plan Area-->
          <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="single_price_plan active wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
            <!-- Side Shape-->
            <div class="side-shape"><img src="https://bootdey.com/img/popular-pricing.png" alt=""></div>
              <div class="title">
                <span>Popular</span>
                <h3>Ultimate</h3>
                <p>Unlimited benefits</p>
                <div class="line"></div>
              </div>
              <div class="price">
                <p>From </p>
                <h4>$49.99</h4>
              </div>
              <div class="description">
                <p><i class="lni lni-checkmark-circle"></i>Duration: from 30 days to 2 years</p>
                <p><i class="lni lni-checkmark-circle"></i>Property Listing Management</p>
                <p><i class="lni lni-checkmark-circle"></i>Booking Calendar</p>
                <p><i class="lni lni-checkmark-circle"></i>Payment Gateway Integration</p>
                <p><i class="lni lni-checkmark-circle"></i>Communication Platform</p>
                <p><i class="lni lni-checkmark-circle"></i>Reviews and Ratings Management</p>
                <p><i class="lni lni-checkmark-circle"></i>Promotional Tools</p>
              </div>
              <div class="button"><a class="btn btn-info" href="#">Get Started</a></div>
            </div>
          </div>
          
          <!-- Single Price Plan Area-->
          <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="single_price_plan active wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
              <div class="title">
                <h3>Free Trial Package</h3>
                <p>Cancellation Option</p>
                <div class="line"></div>
              </div>
              <div class="price">
                <h4>$0</h4>
              </div>
              <div class="description">
              <p><i class="lni lni-checkmark-circle"></i>Duration: from 30 days to 2 years</p>
                <p><i class="lni lni-checkmark-circle"></i>Property Listing Management</p>
                <p><i class="lni lni-checkmark-circle"></i>Booking Calendar</p>
                <p><i class="lni lni-checkmark-circle"></i>Payment Gateway Integration</p>
                <p><i class="lni lni-checkmark-circle"></i>Communication Platform</p>
                <p><i class="lni lni-checkmark-circle"></i>Reviews and Ratings Management</p>
                <p><i class="lni lni-close"></i>Promotional Tools</p>
              </div>
              <div class="button"><a class="btn btn-warning" href="#">Get Started</a></div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection