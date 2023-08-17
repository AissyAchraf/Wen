@extends('site.layouts.layout')

@section('content')
<script src="{{ asset('api.js') }}"></script>

<div class="container-fluid pt-4 px-4 mb-5">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="newsletter-form  rounded h-100 p-4">
                <h6 class="mb-4">Add New Table</h6>

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

                <form action="{{ route('create-table', [app()->getLocale(), $restaurant->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <input type="text" name="restaurant_id" value="{{$restaurant->id}}" hidden>
                        <div class="form-group">
                            <strong>Number</strong>
                            <input type="number" name="number" value="{{ old('number') }}" class="form-control" placeholder="Number">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Price</strong>
                                    <input type="number" name="price" value="{{ old('price') }}" class="form-control" placeholder="Price">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <strong>Capacity</strong>
                                    <input type="number" min="1" name="capacity" value="{{ old('capacity') }}" class="form-control" placeholder="Capacity">
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
                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('restaurant-tables', [app()->getLocale(), $restaurant->id]) }}" class="btn btn-danger">Back</a>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>

@endsection