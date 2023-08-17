@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
        <h6>Sign up</h6>
        <p>Welcome to our Booking Platform Wen! <br> Choose your role</p>
        <div class="line"></div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-5">
            <div class="single-widget-area text-center wow fadeInUp">
                <div class="newsletter-form">
                    <h5>Client</h5>
                    <p>For Client 🧑‍🤝‍🧑</p>
                    <p>Sign up, to unlock a world of opportunities</p>
                    <a href="{{ route('client-registration', app()->getLocale()) }}" class="btn roberto-btn w-100">Sign up</a>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="single-widget-area text-center wow fadeInUp">
                <div class="newsletter-form">
                    <h5>Property</h5>
                    <p>For Property Owner 🏠</p>
                    <p>Sign up, and offer the perfect accommodations</p>
                    <a href="{{ route('business-registration', app()->getLocale()) }}" class="btn roberto-btn w-100">Sign up</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection