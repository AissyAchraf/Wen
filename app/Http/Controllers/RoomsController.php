<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use DateTime;
use View;
use Illuminate\Support\Facades\Auth;

class RoomsController extends Controller
{
    function index() {

    }

    function getRoomsByHotelId($hotelId) {
        $rooms = Room::Where('hotel', '=', $hotelId)->get()->toArray();
        if(!$rooms) {
            return response()->json(['status'=>'failure', 'data'=>"No Rooms found!"], 404);
        }
        return response()->json(['status'=>'success', 'data'=>$rooms], 200);
    }

    function getRoomById($roomId) {
        $room = Room::find($roomId);
        if(!$room) {
            return response()->json(['status'=>'failure', 'data'=>"Room not found!"], 404);
        }
        return response()->json(['status'=>'success', 'data'=>$room], 200);
    }

    function addRoom(Request $request, $hotelId) {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer',
            'price' => 'required|float',
            'photos' => 'required|file[]',
        ]);
        $hotel = Hotel::find($hotelId);
        if(!$hotel) {
            return response()->json(['status'=>'failure', 'data'=>"No Hotel found!"], 404);
        }
        $room = Room::create([
            'number' => $request->number,
            'price' => $request->price,
            'is_available' => true,
            'hotel' => $hotelId,
            'photos' => "",
        ]);
        $uploadedPhotos = $request->file('photos');

            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Rooms/'.$room->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $room->photos === "") {
                    $room->photos = "$photo_full_name";
                } else {
                    $room->photos = $room->photos.","."$photo_full_name";
                }
            }
            $room->update();
        
        return response()->json(['status'=>'success', 'data'=>$room], 200);
    }

    function updateRoom(Request $request, $roomId) {
        $room = Room::find($roomId);
        if(!$room) {
            return response()->json(['status'=>'failure', 'data'=>"No Room found!"], 404);
        }
        if($request->has('number')) {
            $room->number = $request->number;
        }
        if($request->has('price')) {
            $room->price = $request->price;
        }
        if($request->has('is_available')) {
            $room->is_available = $request->is_available;
        }
        if($request->has('hotel')) {
            $room->hotel = $request->hotel;
        }
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Rooms/'.$room->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $room->photos === "") {
                    $room->photos = "$photo_full_name";
                } else {
                    $room->photos = $room->photos.","."$photo_full_name";
                }
            }
        }
        $room->save();
        return response()->json(['status'=>'success', 'data'=>$room], 200);
    }

    function processRoomReservation(Request $request, $locale, $room_id) {
        // dd($room_id);
        if($request->checkinDate == null || $request->checkoutDate == null) {
            return redirect()->back()->withErrors(['notAvailableMessage'=>'You have to choose a range date.'])->withInput();
        }
        //Check if available
        $room = Room::find($room_id);
        if(!$room)
            return redirect()->back()->withErrors(['notAvailableMessage'=>'This room is not available.'])->withInput();
        $reservation = DB::table('reservations')->where('room_id', $room_id)
        ->whereBetween('start_date', [$request->checkinDate, $request->checkoutDate])
        ->orWhereBetween('end_date', [$request->checkinDate, $request->checkoutDate])
        ->get()->first();
        if($reservation) {
            return redirect()->back()->withErrors(['notAvailableMessage'=>'This property is not available for your dates on Wen. Try new dates to check availability.'])->withInput();
        }

        // calculate number of nights
        $datetime1 = new DateTime($request->checkinDate);
        $datetime2 = new DateTime($request->checkoutDate);
        $interval = $datetime1->diff($datetime2);
        $nights = $interval->format('%a');

        $reservationData = [
            'bookingDetails' => $nights.' nights',
            'facilitieType' => 'Room',
            'facilitieData' => $room,
            'checkin' => $request->input('checkinDate'),
            'checkout' => $request->input('checkoutDate'),
            'guests' => $request->input('guests'),
            'unitPrice' => $room->price,
            'totalPrice' => $nights*$room->price,
        ];
        $request->session()->put('reservation_data', $reservationData);
        return redirect()->route('reserve', ['language'=>\App::getLocale()]);
    }

    function deleteRoom($roomId) {
        $room = Room::find($roomId);
        if(!$room) {
            return response()->json(['status'=>'failure', 'data'=>"No Room found!"], 404);
        }
        if($room->photos !== "") {
            try {
                $imagesList = explode(",", $room->photos);
                foreach($imagesList as $image) {
                    $path = "/images/Rooms/".$room->id."/".$image;
                    File::delete(public_path($path));
                }
                File::deleteDirectory(public_path("images/Rooms/".$room->id));
            } catch (Exception $e) {
                return response()->json(["status"=>"failure", "data"=>"We could not delete the room, something wents wrong!"], 201);
            }
        }
        $room->delete();
        return response()->json(['status'=>'success', 'data'=>"Room deleted successfully!"], 200);
    }

    function deletePhotoFromRoom($roomId, $image_name) {
        $room = Room::find($roomId);
        if(!$room) {
            return response()->json(['status'=>'failure', 'data'=>"No Room found!"], 404);
        }
        $imagesList = explode(",", $room->photos);
        $index = array_search($image_name, $imagesList);
        if ($index !== false) {
            unset($imagesList[$index]);
        }
        try {
            $path = "/images/Rooms/".$room->id."/".$image_name;
            File::delete(public_path($path));
        } catch (Exception $e) {
            return response()->json(["status"=>"failure", "message"=>"We could not delete the image, something wents wrong!"], 201);
        }
        $room->photos = implode(",", $imagesList);
        $room->update();
        return response()->json(["status"=>"success", "data"=>"Image deleted successfully!"],200);
    }

    function roomsByHotel(Request $request, $locale, $hotel_id) {
        $hotel = DB::table('hotels')->where('id', $hotel_id)->get()->first();
        $rooms = Room::Where('hotel', '=', $hotel_id)->paginate(5)->appends($request->all());;
        $data = [
            'hotel'  => $hotel,
            'rooms'   => $rooms,
        ];
        return View::make('site.Hotels.roomsList')->with($data);
    }

    function edit($locale, $room_id) {
        $room = Room::find($room_id);
        return view('site.Hotels.updateRoom', compact('room'));
    }

    function update(Request $request, $locale, $room_id) {
        $room = Room::find($room_id);
        if(!$room) {
            return response()->json(['status'=>'failure', 'data'=>"No Room found!"], 404);
        }
        if($request->has('number')) {
            $room->number = $request->number;
        }
        if($request->has('price')) {
            $room->price = $request->price;
        }
        if($request->has('is_available')) {
            $room->is_available = $request->is_available;
        }
        if($request->has('amenities')) {
            $room->amenities = $request->amenities;
        }
        if($request->has('surface')) {
            $room->surface = $request->surface;
        }
        if($request->has('room_type')) {
            $room->room_type = $request->room_type;
        }
        if($request->has('beds_type')) {
            $room->beds_type = $request->beds_type;
        }
        if($request->has('capacity')) {
            $room->capacity = $request->capacity;
        }
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Rooms/'.$room->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $room->photos === "") {
                    $room->photos = "$photo_full_name";
                } else {
                    $room->photos = $room->photos.","."$photo_full_name";
                }
            }
        }
        $room->save();
        return redirect()->route('edit-room', ['language'=>\App::getLocale(), 'id'=>$room->id]);
    }

    function create(Request $request, $locale) {
        $user = Auth::user();
        $hotel = Hotel::where('user_manager', $user->id)->get()->first();
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'photos.*' => 'required|mimes:jpg,jpeg,png,bmp,webp|max:20000',
            'room_type' => 'required|string',
            'beds_type' => 'required|string',
            'surface' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'required|string',
            'is_available' => 'required|boolean',
        ]);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        if(!$hotel) {
            return response()->json(['status'=>'failure', 'data'=>"No Hotel found!"], 404);
        }
        $room = Room::create([
            'number' => $request->number,
            'price' => $request->price,
            'is_available' => true,
            'hotel' => $hotel->id,
            'photos' => "",
            'room_type' => $request->room_type,
            'beds_type' => $request->beds_type,
            'surface' => $request->surface,
            'capacity' => $request->capacity,
            'amenities' => $request->amenities,
        ]);
        $uploadedPhotos = $request->file('photos');

        foreach ($uploadedPhotos as $i => $photo) {
            $ext = $photo->getClientOriginalExtension();
            $photo_full_name = date('YmdHis').".".$i.".".$ext;
            $destinationPath = '/images/Rooms/'.$room->id;
            $photo->move(public_path($destinationPath), $photo_full_name);
            if($i == 0 && $room->photos === "") {
                $room->photos = "$photo_full_name";
            } else {
                $room->photos = $room->photos.","."$photo_full_name";
            }
        }
        $room->update();
        return redirect()->route('hotel-rooms', ['language'=>\App::getLocale(), 'id'=>$hotel->id]);
    }
}
