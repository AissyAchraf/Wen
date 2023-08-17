<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use DateTime;

class HotelsController extends Controller
{
    function getHotels() {
        $hotels = Hotel::all();
        if(!$hotels) {
            return response()->json(['status'=>'failure', 'data'=>'No Hotel found'], 201);
        }
        return response()->json(['status'=>'success', 'data'=>$hotels], 200);
    }

    function getHotelsList(Request $request) {
        if ($request->checkoutDate != null && $request->checkinDate != null) {
            $hotels = DB::table("hotels")
            ->where('hotels.status', 1)
            ->leftJoin('rooms', function ($join) use ($request) {
                $join->on('hotels.id', '=', 'rooms.hotel');
            })
            ->leftJoin('reservations', function ($join) use ($request) {
                $join->on('rooms.id', '=', 'reservations.room_id')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('reservations.start_date', [$request->checkinDate, $request->checkoutDate])
                        ->orWhereBetween('reservations.end_date', [$request->checkinDate, $request->checkoutDate])
                        ->orWhereNull('reservations.id');
                });
            })
            ->when($request->guests != null, function($q) use ($request) {
                $this->queryByGuestsValue($request, $q);
            })
            ->whereNull('reservations.id')
            ->when($request->price_min != null && $request->price_max != null, function($q) use ($request) {
                return $q->whereBetween('rooms.price', [$request->price_min, $request->price_max]);
            })
            ->select('hotels.*')
            ->groupBy('hotels.id')
            ->when($request->stars != null && $request->stars >= 1 && $request->stars <= 4, function($q) use ($request) {
                $this->queryByStarsValue($request, $q);
            })
            ->paginate(5)->appends($request->all());
        } else {
            $hotels = DB::table("hotels")
            ->where('hotels.status', 1)
            ->leftJoin('rooms', function ($join) use ($request) {
                $join->on('hotels.id', '=', 'rooms.hotel');
            })
            ->when($request->guests != null, function($q) use ($request) {
                $this->queryByGuestsValue($request, $q);
            })
            ->when($request->price_min != null && $request->price_max != null, function($q) use ($request) {
                return $q->whereBetween('rooms.price', [$request->price_min, $request->price_max]);
            })
            ->select('hotels.*')
            ->groupBy('hotels.id')
            ->when($request->stars != null, function($q) use ($request) {
                $this->queryByStarsValue($request, $q);
            })
            ->paginate(5)->appends($request->all());
        }
        if(!$hotels) {
            return response()->json(['status'=>'failure', 'data'=>'No Hotel found'], 201);
        }
        return view('site.Hotels.hotelsList', compact('hotels'));
    }

    function getHotelById($hotel_id) {
        $hotel = Hotel::find($hotel_id);
        if(!$hotel) {
            return response()->json(['status'=>'failure', 'data'=>'No Hotel found'], 201);
        }
        return response()->json(['status'=>'success', 'data'=>$hotel], 200);
    }

    function getHotel(Request $request, $locale, $hotel_id) {
        $request->session()->forget('reservation_data');
        $request->session()->forget('number_nights');
        $hotel = Hotel::find($hotel_id);
        if(!$hotel)
            return response()->json(["status"=>"failure", "data"=>"Hotel not found!"], 404);
        if ($request->checkoutDate != null && $request->checkinDate != null) {
            $availableRooms = Room::where('hotel', '=', $hotel->id)->whereDoesntHave('reservations', function ($query) use ($request) {
                // Check for overlapping reservations
                $query->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->checkinDate, $request->checkoutDate])
                          ->orWhereBetween('end_date', [$request->checkinDate, $request->checkoutDate]);
                });
            })
            ->when($request->guests != null, function($q) use ($request) {
                $this->queryByGuestsValue($request, $q);
            })
            ->paginate(5)->appends($request->all());
            $hotel->rooms = $availableRooms;
            
            // calculate the number of nights
            $datetime1 = new DateTime($request->checkinDate);
            $datetime2 = new DateTime($request->checkoutDate);
            $interval = $datetime1->diff($datetime2);
            $nights = $interval->format('%a');

            $request->session()->put('number_nights', $nights);
        } else {
            $hotel->rooms = DB::table("rooms")
            ->where('hotel', '=', $hotel->id)
            ->when($request->guests != null, function($q) use ($request) {
                $this->queryByGuestsValue($request, $q);
            })
            ->paginate(5)->appends($request->all());
        }
        return view('site.Hotels.hotelDetails', compact('hotel'));
    }

    function addHotel(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'photos' => 'required|file[]',
            'stars' => 'required|integer',
            'amenities' => 'required|string',
            'room_service' => 'required|integer',
            
        ]);
        $hotel = Hotel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'photos' => "",
            'stars' => $request->stars,
            'amenities' => $request->amenities,
            'room_service' => $request->room_service,
        ]);
        $uploadedPhotos = $request->file('photos');

        foreach ($uploadedPhotos as $i => $photo) {
            $ext = $photo->getClientOriginalExtension();
            $photo_full_name = date('YmdHis').".".$i.".".$ext;
            $destinationPath = '/images/Hotels/'.$hotel->id;
            $photo->move(public_path($destinationPath), $photo_full_name);
            if($i == 0 && $hotel->photos === "") {
                $hotel->photos = "$photo_full_name";
            } else {
                $hotel->photos = $hotel->photos.","."$photo_full_name";
            }
        }
        $hotel->update();
        return response()->json(['status'=>'success', 'data'=>$hotel], 200);
    }

    function updateHotel(Request $request, $locale, $hotel_id) {
        $hotel = Hotel::find($hotel_id);
        if(!$hotel) {
            return response()->json(['status'=>'failure', 'data'=>'No Hotel found'], 201);
        }
        if($request->has('name')) {
            $hotel->name = $request->name;
        }
        if($request->has('email')) {
            $hotel->email = $request->email;
        }
        if($request->has('phone')) {
            $hotel->phone = $request->phone;
        }
        if($request->has('description')) {
            $hotel->description = $request->description;
        }
        if($request->has('address')) {
            $hotel->address = $request->address;
        }
        if($request->has('stars')) {
            $hotel->stars = $request->stars;
        }
        if($request->has('amenities')) {
            $hotel->amenities = $request->amenities;
        }
        if($request->has('room_service')) {
            $hotel->room_service = $request->room_service;
        }
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Hotels/'.$hotel->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $hotel->photos === "") {
                    $hotel->photos = "$photo_full_name";
                } else {
                    $hotel->photos = $hotel->photos.","."$photo_full_name";
                }
            } 
        }
        $hotel->update();
        return response()->json(['status'=>'success', 'data'=>$hotel], 200);
    }

    function deleteHotel($hotel_id) {
        $hotel = Hotel::find($hotel_id);
        if(!$hotel) {
            return response()->json(['status'=>'failure', 'data'=>'No hotel found'], 201);
        }
        if($hotel->photos !== "") {
            try {
                $imagesList = explode(",", $hotel->photos);
                foreach($imagesList as $image) {
                    $path = "/images/Hotels/".$hotel->id."/".$image;
                    File::delete(public_path($path));
                }
                File::deleteDirectory(public_path("images/Hotels/".$hotel->id));
            } catch (Exception $e) {
                return response()->json(["status"=>"failure", "data"=>"We could not delete the room, something wents wrong!"], 201);
            }
        }
        $hotel->delete();
        return response()->json(['status'=>'success', 'data'=>'Hotel deleted successfully!'], 200);
    }

    function deletePhotoFromHotel($hotelId, $image_name) {
        $hotel = Hotel::find($hotelId);
        if(!$hotel) {
            return response()->json(['status'=>'failure', 'data'=>"No Hotel found!"], 404);
        }
        $imagesList = explode(",", $hotel->photos);
        $index = array_search($image_name, $imagesList);
        if ($index !== false) {
            unset($imagesList[$index]);
        }
        try {
            $path = "/images/Rooms/".$hotel->id."/".$image_name;
            File::delete(public_path($path));
        } catch (Exception $e) {
            return response()->json(["status"=>"failure", "message"=>"We could not delete the image, something wents wrong!"], 201);
        }
        $hotel->photos = implode(",", $imagesList);
        $hotel->update();
        return response()->json(["status"=>"success", "data"=>"Image deleted successfully!"],200);
    }

    function edit($locale, $hotel_id) {
        $hotel = Hotel::find($hotel_id);
        return view('site.Hotels.updateHotel', compact('hotel'));
    }

    function update(Request $request, $locale, $hotel_id) {
        $hotel = Hotel::find($hotel_id);
        if(!$hotel) {
            return response()->json(["status"=>"failure", "message"=>"Hotel not found!"], 404);
        }
        if($request->has('name')) {
            $hotel->name = $request->name;
        }
        if($request->has('description')) {
            $hotel->description = $request->description;
        }
        if($request->has('address')) {
            $hotel->address = $request->address;
        }
        if($request->has('stars')) {
            $hotel->stars = $request->stars;
        }
        if($request->has('phone')) {
            $hotel->phone = $request->phone;
        }
        if($request->has('phone')) {
            $hotel->phone = $request->phone;
        }
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Hotels/'.$hotel->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $hotel->photos === "") {
                    $hotel->photos = "$photo_full_name";
                } else {
                    $hotel->photos = $hotel->photos.","."$photo_full_name";
                }
            } 
        }
        $hotel->update();
        return redirect()->route('edit-hotel', ['language'=>\App::getLocale(), 'id'=>$hotel->id]);
    }

    function addRoom($locale, $hotel_id) {
        $hotel = Hotel::find($hotel_id);
        return view('site.Hotels.addRoom', compact('hotel'));
    }

    function queryByStarsValue($request, $q) {
        switch ($request->stars) {
            case '1':
                return $q->whereBetween('hotels.stars', [1, 2]);
                break;
            case '2':
                return $q->whereBetween('hotels.stars', [2, 3]);
                break;
            case '3':
                return $q->whereBetween('hotels.stars', [3, 4]);
                break;
            case '4':
                return $q->whereBetween('hotels.stars', [4, 5]);
                break;
        }
    }

    function queryByGuestsValue($request, $q) {
        switch ($request->guests) {
            case '1':
                return $q->whereBetween('rooms.capacity', [1, 2]);
                break;
            case '2':
                return $q->whereBetween('rooms.capacity', [2, 3]);
                break;
            case '3':
                return $q->whereBetween('rooms.capacity', [3, 4]);
                break;
            case '4':
                return $q->where('rooms.capacity', '>=', 4);
                break;
        }
    }
}