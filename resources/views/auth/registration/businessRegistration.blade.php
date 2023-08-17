@extends('layouts.app')

@section('content')

<div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
    <h6>Sign up - Property</h6>
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

<div class="col-lg-6 col-md-8 mx-auto">
    <div class="wow fadeInUp">
        <form method="POST" action="{{ route('register', app()->getLocale()) }}" id="signup-form" class="signup-form">
            @csrf
            <h3>
                Account Setup
            </h3>
            <fieldset>
                <h2>Creat your account</h2>
                <div class="form-group  @error('password') is-invalid @enderror">
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
                Property Infos
            </h3>
            <fieldset>
                <h2>Property Infos</h2>
                <div class="form-group">
                    <input type="text" name="property_name" value="{{ old('property_name') }}" id="property_name" placeholder="{{ __('Property Name') }}"/>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" value="{{ old('phone') }}" id="phone" placeholder="{{ __('Phone') }}"/>
                </div>
                <div class="form-group">
                    <select class="form-control" name="property_type" id="property_type">
                        <option value="">Property Type</option>
                        <option value="hotel">Hotel</option>
                        <option value="restaurant">Restaurant</option>
                        <option value="chalet">Chalet</option>
                    </select>
                </div>
            </fieldset>

            <h3>
                Property Details
            </h3>
            <fieldset> 
                <h2>Property Details</h2>
                <input type="text" name="address" id="address" class="form-control mb-2" placeholder="Address"/>
                <input type="text" name="latitude" id="latitude" hidden/>
                <input type="text" name="longitude" id="longitude" hidden/>
                <div id="map" style="height:150px;width:100%;"></div>
                <p></p>
            </fieldset>
        </form>
    </div>

</div>

@endsection

@section('script')

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        let marker, circle, zoomed;

        navigator.geolocation.watchPosition(success, error);

        function success(pos) {

            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const accuracy = pos.coords.accuracy;

            if (marker) {
                map.removeLayer(marker);
                map.removeLayer(circle);
            }
            // Removes any existing marker and circule (new ones about to be set)

            marker = L.marker([lat, lng]).addTo(map);
            circle = L.circle([lat, lng], { radius: accuracy }).addTo(map);
            // Adds marker to the map and a circle for accuracy

            if (!zoomed) {
                zoomed = map.fitBounds(circle.getBounds()); 
            }
            // Set zoom to boundaries of accuracy circle

            map.setView([lat, lng], 13);
            // Set map focus to current user position

        }

        function error(err) {

            if (err.code === 1) {
                alert("Please allow geolocation access");
            } else {
                alert("Cannot get current location");
            }

        }

        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(map);
            $("#latitude").val(e.latlng.lat);
            $("#longitude").val(e.latlng.lng);
            L.esri.Geocoding
            .reverseGeocode({
                apikey: "AAPK1e0290c837ed45e2be6b17936079607bguRvZcu5uYkFyZu2qVkehUOPSbuKk9wYsNsiVKYRhW5awupu6ems6FOiEH3LlwEW"
            })
            .latlng(e.latlng)
            .run(function (error, result) {
                if (error) {
                return;
                }

                L.marker(result.latlng).addTo(map).bindPopup(result.address.Match_addr).openPopup();
            });
        }

        map.on('click', onMapClick);
    </script>
    @stop