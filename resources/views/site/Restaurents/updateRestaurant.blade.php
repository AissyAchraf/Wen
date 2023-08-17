@extends('site.layouts.layout')

@section('content')
<script src="{{ asset('api.js') }}"></script>

<div class="container-fluid pt-4 px-4 mb-5">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="newsletter-form  rounded h-100 p-4">
                <h6 class="mb-4">Update Restaurant - {{$restaurant->name}}</h6>
                @php 
                    $Imageslist = explode(",", $restaurant->photos);
                @endphp

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

                <form action="{{ route('update-restaurant', [app()->getLocale(), $restaurant->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <input type="text" name="hotel" value="{{$restaurant->id}}" hidden>
                        <div class="form-group">
                            <strong>Name</strong>
                            <input type="text" name="name" value="{{ $restaurant->name }}" class="form-control" placeholder="Title">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="form-group">
                            <strong>Description</strong>
                            <textarea name="description" class="form-control" placeholder="Description" rows="10">{{ $restaurant->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Location</strong>
                                    <input type="text" name="address" value="{{ $restaurant->address }}" class="form-control" placeholder="Address">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Phone</strong>
                                    <input type="text" name="phone" value="{{ $restaurant->phone }}" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Capacity</strong>
                                    <input type="number" name="capacity" value="{{ $restaurant->capacity }}" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Cuisine</strong>
                                    <input type="text" name="cuisine" value="{{ $restaurant->cuisine }}" class="form-control" placeholder="Cuisine">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Photos</strong>
                                    <!-- <input type="file" id="postImagesInput" name="postImagesList[]" accept="image/*" multiple class="form-control"> -->
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
                        @if(empty($Imageslist))
                            <p class="mt-3">No Image found</p>
                        @else
                        <div class="row mt-3 mb-5">
                            @foreach ($Imageslist as $image)
                                <div class="col-sm-3 mb-5 image-list">
                                    <img src="/images/Restaurents/{{$restaurant->id}}/{{$image}}" class="img-thumbnail h-100">
                                    <button type="button" onclick="deletePhotoFromRestaurant('{{$restaurant->id}}', '{{ $image }}')" class="btn btn-danger mt-2 deleteImage"><i class="fa fa-trash"></i></button>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('restaurents', [app()->getLocale(), $restaurant->id]) }}" class="btn btn-danger">Back</a>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>

@endsection