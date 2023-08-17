@extends('site.layouts.layout')

@section('content')
<script src="{{ asset('api.js') }}"></script>

<div class="container-fluid pt-4 px-4 mb-5">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="newsletter-form  rounded h-100 p-4">
                <h6 class="mb-4">Update Table N°: {{ $table->number }}</h6>
                @php 
                    $Imageslist = explode(",", $table->photos);
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

                <form action="{{ route('update-table', [app()->getLocale(), $table->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-xs-4 col-sm-4 col-md-12 mb-2">
                        <input type="text" name="id" value="{{$table->id}}" hidden>
                        <div class="form-group">
                            <strong>Number</strong>
                            <input type="number" name="number" value="{{ $table->number }}" class="form-control" placeholder="Number">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Price</strong>
                                    <input type="number" name="price" value="{{ $table->price }}" class="form-control" placeholder="Price">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Capacity</strong>
                                    <input type="number" min="1" name="capacity" value="{{ $table->capacity }}" class="form-control" placeholder="Capacity">
                                </div>
                            </div>
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
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="d-flex justify-content-between col-lg-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="radio" name="is_available" id="availableRadio" {{ $table->is_available == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="availableRadio">
                                        Available
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="radio" name="is_available" id="availableRadio1" {{ $table->is_available == 0 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="availableRadio1">
                                        Not Available
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        @if(empty($Imageslist))
                            <p class="mt-3">No Image found</p>
                        @else
                        <div class="row mt-3 mb-5">
                            @foreach ($Imageslist as $image)
                                <div class="col-sm-3 mb-5 image-list">
                                    <img src="/images/Tables/{{$table->id}}/{{$image}}" class="img-thumbnail h-100">
                                    <button type="button" onclick="deletePhotoFromTable('{{$table->id}}', '{{ $image }}')" class="btn btn-danger mt-2 deleteImage"><i class="fa fa-trash"></i></button>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('restaurant-tables', [app()->getLocale(), $table->restaurent_id]) }}" class="btn btn-danger">Back</a>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>

@endsection