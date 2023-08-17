@extends('layouts.app')

@section('content')

<div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
    <h6>Sign up - Client</h6>
    <div class="line"></div>
</div>

@if($errors->any())
    <div class="col-4 mx-auto wow fadeInUp mb-3">
       <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger">- {{ __($error) }}</li>
            @endforeach
            </ul>
        </div> 
    </div>  
@endif

<div class="registration-container">
    <div class="wow fadeInUp">
        <form method="POST" action="{{ route('register', app()->getLocale()) }}" id="signup-form" class="signup-form">
            @csrf
            <h3>
                Account Setup
            </h3>
            <fieldset>
                <h2>Creat your account</h2>
                <div class="form-group  @error('password') border-danger @enderror">
                    <input type="email" name="email" value="{{ old('email') }}" id="email" placeholder="{{ __('Email Address') }}"/>
                </div>
                <div class="form-group  @error('password') is-invalid @enderror">
                    <input type="password" name="password" value="{{ old('password') }}" id="password" placeholder="{{ __('Password') }}"/>
                </div>
                <div class="form-group  @error('password') is-invalid @enderror">
                    <input type="password" name="password_confirmation" value="{{ old('repassword') }}" id="repassword" placeholder="{{ __('Confirm Password') }}"/>
                </div>
            </fieldset>
            <h3>
                Personal Infos
            </h3>
            <fieldset>
                <h2>Personal Infos</h2>
                <div class="form-group  @error('name') is-invalid @enderror">
                    <input type="text" name="name" value="{{ old('name') }}" id="name" placeholder="{{ __('Name') }}"/>
                    
                </div>
                <div class="form-group  @error('phone') is-invalid @enderror">
                    <input type="text" name="phone" value="{{ old('phone') }}" id="password" placeholder="{{ __('Phone') }}"/>
                </div>
            </fieldset>
        </form>
    </div>

</div>

<script>
   $(document).ready(function(){
      $("#signup-form").validate();
    });
</script>

@endsection