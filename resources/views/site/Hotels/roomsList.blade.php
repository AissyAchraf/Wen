@extends('site.layouts.layout')

@section('content')

<script src="{{ asset('api.js') }}"></script>

<div class="container-fluid pt-4 px-4 mb-5">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="newsletter-form  rounded h-100 p-4">
                
                <h6 class="mb-4">Rooms - {{$hotel->name}}</h6>
                <form class="mr-2" action="{{ route('add-room', [app()->getLocale(), $hotel->id]) }}">
                    <button type="submit" class="btn btn-outline-success float-right mb-5"><i class="fa fa-plus"></i> Add New Room</button>
                </form> 
            
                <div class="table-responsive table-dark">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <!-- <th scope="col"><input class="form-check-input" type="checkbox"></th> -->
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Number</th>
                                <th scope="col">Type</th>
                                <th scope="col">Beds Type</th>
                                <th scope="col">Price</th>
                                <th scope="col">Availability</th>
                                <th scope="col">Surface</th>
                                <th scope="col">Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($rooms as $r)
                            @php 
                                $Imageslist = explode(",", $r->photos);
                            @endphp
                            <tr>
                                <td>
                                    <div class="square-image">
                                        @if($r->photos != "")
                                        <img style="width:100px;" src="{{ asset('/images/Rooms/'.$r->id.'/'.$Imageslist[0]) }}"/>
                                        @else
                                        <img src="/images/no-image.jpg"/>
                                        @endif
                                    </div> 
                                </td>
                                <td>{{ $r->number }}</td>
                                <td>{{ $r->room_type }}</td>
                                <td>{{ $r->beds_type }}</td>
                                <td>${{ $r->price }}</td>
                                <td>
                                    @if($r->is_available)
                                    <span class="bg-success rounded px-2 py-1">available</span>
                                    @else
                                    <span class="bg-warning rounded px-2 py-1">not available</span>
                                    @endif
                                </td>
                                <td>{{ $r->surface }}</td>
                                <td>{{ $r->capacity }}</td>
                                <td>
                                    <form action="{{ route('delete-room', [app()->getLocale(), $r->id]) }}" method="POST">
                                        <a class="btn btn-light" href="{{ route('edit-room', [app()->getLocale(), $r->id]) }}"><i class="fas fa-pen"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteRoom({{$r->id}})" class="btn btn-danger" id="deletePostBtn" data-postid="{{ $r->id }}"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3 ml-1">
                {{ $rooms->appends(request()->except('page'))->links('site.paginationLinks') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection