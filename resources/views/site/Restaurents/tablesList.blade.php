@extends('site.layouts.layout')

@section('content')

<script src="{{ asset('api.js') }}"></script>

<div class="container-fluid pt-4 px-4 mb-5">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="newsletter-form  rounded h-100 p-4">
                
                <h6 class="mb-4">Tables - {{$restaurant->name}}</h6>
                <form class="mr-2" action="{{ route('add-table', [app()->getLocale(), $restaurant->id]) }}">
                    <button type="submit" class="btn btn-outline-success float-right mb-5"><i class="fa fa-plus"></i> Add New Table</button>
                </form> 
            
                <div class="table-responsive table-dark">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">Photo</th>
                                <th scope="col">Number</th>
                                <th scope="col">Price</th>
                                <th scope="col">Availability</th>
                                <th scope="col">Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tables as $t)
                            @php 
                                $Imageslist = explode(",", $t->photos);
                            @endphp
                            <tr>
                                <td>
                                    <div class="square-image">
                                        @if($t->photos != "")
                                        <img style="width:100px;" src="{{ asset('/images/Tables/'.$t->id.'/'.$Imageslist[0]) }}"/>
                                        @else
                                        <img src="/images/no-image.jpg"/>
                                        @endif
                                    </div> 
                                </td>
                                <td>{{ $t->number }}</td>
                                <td>${{ $t->price }}</td>
                                <td>
                                    @if($t->is_available)
                                    <span class="bg-success rounded px-2 py-1">available</span>
                                    @else
                                    <span class="bg-warning rounded px-2 py-1">not available</span>
                                    @endif
                                </td>
                                <td>{{ $t->capacity }}</td>
                                <td>
                                    <form method="POST">
                                        <a class="btn btn-light" href="{{ route('edit-table', [app()->getLocale(), $t->id]) }}"><i class="fas fa-pen"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteTable({{$t->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3 ml-1">
                {{ $tables->appends(request()->except('page'))->links('site.paginationLinks') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection