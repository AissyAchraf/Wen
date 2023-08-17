@extends('site.layouts.layout')

@section('content')
<script src="{{ asset('api.js') }}"></script>

<div class="container-fluid pt-4 px-4 mb-5">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="newsletter-form  rounded h-100 p-4">
                <h6 class="mb-4">Add New Room</h6>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('create-room', [app()->getLocale(), $hotel->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="text" name="hotel" value="{{ $hotel->id }}" hidden>
                                <div class="form-group">{{ __('') }}
                                    <strong>{{ __('Room Type') }}</strong>
                                    <input type="text" name="room_type" value="{{ old('room_type') }}" class="form-control" placeholder="Room Type">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">{{ __('') }}
                                    <strong>{{ __('Beds Type') }}</strong>
                                    <input type="text" name="beds_type" value="{{ old('beds_type') }}" class="form-control" placeholder="Beds Type">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>{{ __('Room Number') }}</strong>
                                    <input type="number" name="number" value="{{ old('number') }}" class="form-control" placeholder="Room Number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Price per night</strong>
                                    <input type="number" name="price" value="{{ old('price') }}" class="form-control" placeholder="Price/night">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Surface m<sup>2</sup></strong>
                                    <input type="number" min="0" name="surface" value="{{ old('surface') }}" class="form-control" placeholder="Surface">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Capacity</strong>
                                    <input type="number" min="1" name="capacity" value="{{ old('capacity') }}" class="form-control" placeholder="Capacity">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Amenities</strong>
                                    <input type="text" name="amenities" value="{{ old('amenities') }}" class="form-control" placeholder="Amenities">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="radio" name="is_available" id="availableRadio">
                                    <label class="form-check-label" for="availableRadio">
                                        Available
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="radio" name="is_available" id="availableRadio1">
                                    <label class="form-check-label" for="availableRadio1">
                                        Not Available
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Photos</strong>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="photos[]" accept="image/*" multiple class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>

@endsection