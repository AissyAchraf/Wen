<?php

namespace App\Http\Controllers;

use App\Rules\MultipleOf12;
use Illuminate\Http\Request;
use App\Models\Chalet;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use DateTime;

class ChaletsController extends Controller
{
    public function getChalets()
    {
        $chalets = Chalet::all();
        if ($chalets->isEmpty()) {
            return response()->json(['status' => 'failure', 'data' => 'No Chalet found'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $chalets], 200);
    }

    function getChaletsList(Request $request, $locale) {

        $validator = Validator::make($request->all(), [
            'date' => 'date',
            'checkinHour' => 'date_format:H:i',
            'booking_intervals' => 'integer|min:1',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if ($request->date != null && $request->checkinHour != null && $request->booking_intervals != null) {

            $checkinDate = $request->date.' '.$request->checkinHour;
            $checkinDatetime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $checkinDate);

            $bookingDurationHours = $request->booking_intervals * 12;
            $checkoutDate = $checkinDatetime->copy()->addHours($bookingDurationHours)->format('Y-m-d H:i');

            // dd($checkoutDate);
            $chalets = DB::table('chalets')
            ->where('chalets.status', 1)
            ->leftJoin('reservations', function ($join) use ($checkinDate, $checkoutDate) {
                $join->on('chalets.id', '=', 'reservations.chalet_id')
                    ->where(function ($query) use ($checkinDate, $checkoutDate) {
                        $query->whereBetween('reservations.start_date', [$checkinDate, $checkoutDate])
                            ->orWhereBetween('reservations.end_date', [$checkinDate, $checkoutDate])
                            ->orWhereNull('reservations.id');
                    });
            })
            ->whereNull('reservations.id')
            ->select('chalets.*')
            ->groupBy('chalets.id')
            ->when($request->price_min != null && $request->price_max != null, function($q) use ($request) {
                return $q->whereBetween('rental_price', [$request->price_min, $request->price_max]);
            })
            ->when($request->guests != null, function($q) use ($request) {
                return $q->where('capacity', '>=', $request->guests);
            })
            ->paginate(5)->appends($request->all());
        } else {
            $chalets = Chalet::where('status', 1)->when($request->price_min != null && $request->price_max != null, function($q) use ($request) {
                return $q->whereBetween('rental_price', [$request->price_min, $request->price_max]);
            })
            ->when($request->guests != null, function($q) use ($request) {
                return $q->where('capacity', '>=', $request->guests);
            })->groupBy('chalets.id')->paginate(5)->appends($request->all());
        }
    
        return view('site.Chalets.chaletsList', compact('chalets'));
    }

    public function getChaletById($chalet_id)
    {
        $chalet = Chalet::find($chalet_id);
        if (!$chalet) {
            return response()->json(['status' => 'failure', 'data' => 'No Chalet found'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $chalet], 200);
    }

    public function getChalet(Request $request, $locale, $chalet_id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'date',
            'checkinHour' => 'date_format:H:i',
            'booking_intervals' => 'integer|min:1',
        ]);
            
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        $chalet = Chalet::find($chalet_id);
        // check available
        if($request->date != null && $request->checkinHour != null && $request->booking_intervals != null) {

            $checkinDate = $request->date.' '.$request->checkinHour;
            $checkinDatetime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $checkinDate);

            $bookingDurationHours = $request->booking_intervals * 12;
            $checkoutDate = $checkinDatetime->copy()->addHours($bookingDurationHours)->format('Y-m-d H:i');

            $reservation = DB::table('reservations')
            ->whereNotNull('chalet_id')
            ->whereBetween('start_date', [$checkinDate, $checkoutDate])
            ->orWhereBetween('end_date', [$checkinDate, $checkoutDate])
            ->where('chalet_id', $chalet_id)
            ->get()->first();
            if($reservation) {
                return redirect()->back()->withErrors(['notAvailableMessage'=>'This property is not available for your dates on Wen. Try new dates to check availability.'])->withInput();
            }
            
            // calculate number of nights
            $datetime1 = new DateTime($checkinDate);
            $datetime2 = new DateTime($checkoutDate);
            $interval = $datetime1->diff($datetime2);
            $hours = $interval->format('%h');
            $minutes = $interval->format('%i');
            $days = $interval->format('%a');

            // Convert any excess minutes to hours
            $hours += $minutes / 60;

            // Calculate whole days from hours and update hours accordingly
            $days += ($hours / 24);
            $hours = $hours % 24;
            
            $reservationData = [
                'bookingDetails' => ($request->booking_intervals > 1 ? $days.' days' : 'Half day'),
                'facilitieType' => 'Chalet',
                'facilitieData' => $chalet,
                'checkin' => $checkinDate,
                'checkout' => $checkoutDate,
                'unitPrice' => $chalet->rental_price,
                'totalPrice' => $days*$chalet->rental_price,
            ];
            $request->session()->put('reservation_data', $reservationData);
        }
        return view('site.Chalets.chaletDetails', compact('chalet'));
    }

    public function addChalet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'photos' => 'required|file[]',
            'capacity' => 'required|integer',
            'rental_price' => 'required|float',
            'available' => 'required|boolean',
        ]);
        $chalet = Chalet::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
            'photos' => "",
            'capacity' => $request->input('capacity'),
            'rental_price' => $request->input('rental_price'),
            'available' => $request->input('available'),
        ]);
        $uploadedPhotos = $request->file('photos');
        foreach ($uploadedPhotos as $i => $photo) {
            $ext = $photo->getClientOriginalExtension();
            $photo_full_name = date('YmdHis').".".$i.".".$ext;
            $destinationPath = '/images/Chalets/'.$chalet->id;
            $photo->move(public_path($destinationPath), $photo_full_name);
            if($i == 0 && $chalet->photos === "") {
                $chalet->photos = "$photo_full_name";
            } else {
                $chalet->photos = $chalet->photos.","."$photo_full_name";
            }
        }
        $chalet->update();
        return response()->json(['status' => 'success', 'data' =>$chalet], 200);
    }

    public function updateChalet(Request $request, $chalet_id)
    {
        $chalet = Chalet::find($chalet_id);
        if (!$chalet) {
            return response()->json(['status' => 'failure', 'data' => 'No Chalet found'], 404);
        }
        $chalet->name = $request->input('name', $chalet->name);
        $chalet->email = $request->input('email', $chalet->email);
        $chalet->phone = $request->input('phone', $chalet->phone);
        $chalet->description = $request->input('description', $chalet->description);
        $chalet->address = $request->input('address', $chalet->address);
        $chalet->capacity = $request->input('capacity', $chalet->capacity);
        $chalet->rental_price = $request->input('rental_price', $chalet->rental_price);
        $chalet->available = $request->input('available', $chalet->available);
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Chalets/'.$chalet->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $chalet->photos === "") {
                    $chalet->photos = "$photo_full_name";
                } else {
                    $chalet->photos = $chalet->photos.","."$photo_full_name";
                }
            }
        }
        $chalet->update();
        return response()->json(['status' => 'success', 'data' => $chalet], 200);
    }

    public function deleteChalet($chalet_id)
    {
        $chalet = Chalet::find($chalet_id);
        if (!$chalet) {
            return response()->json(['status' => 'failure', 'data' => 'No chalet found'], 404);
        }
        if($chalet->photos !== "") {
            try {
                $imagesList = explode(",", $chalet->photos);
                foreach($imagesList as $image) {
                    $path = "/images/Chalets/".$chalet->id."/".$image;
                    File::delete(public_path($path));
                }
                File::deleteDirectory(public_path("images/Chalets/".$chalet->id));
            } catch (Exception $e) {
                return response()->json(["status"=>"failure", "data"=>"We could not delete the room, something wents wrong!"], 201);
            }
        }
        $chalet->delete();
        return response()->json(['status' => 'success', 'data' => 'Chalet deleted successfully!'], 200);
    }

    function deletePhotoFromChalet($chaletId, $image_name) {
        $chalet = Chalet::find($chaletId);
        if(!$chalet) {
            return response()->json(['status'=>'failure', 'data'=>"No chalet found!"], 404);
        }
        $imagesList = explode(",", $chalet->photos);
        $index = array_search($image_name, $imagesList);
        if ($index !== false) {
            unset($imagesList[$index]);
        }
        try {
            $path = "/images/Chalets/".$chalet->id."/".$image_name;
            File::delete(public_path($path));
        } catch (Exception $e) {
            return response()->json(["status"=>"failure", "message"=>"We could not delete the image, something wents wrong!"], 201);
        }
        $chalet->photos = implode(",", $imagesList);
        $chalet->update();
        return response()->json(["status"=>"success", "data"=>"Image deleted successfully!"],200);
    }

    function edit($locale, $chalet_id) {
        $chalet = Chalet::find($chalet_id);
        return view('site.Chalets.updateChalet', compact('chalet'));
    }

    function update(Request $request, $locale, $chalet_id) {
        $chalet = Chalet::find($chalet_id);
        if (!$chalet) {
            return response()->json(['status' => 'failure', 'data' => 'No Chalet found'], 404);
        }
        $chalet->name = $request->input('name', $chalet->name);
        $chalet->email = $request->input('email', $chalet->email);
        $chalet->phone = $request->input('phone', $chalet->phone);
        $chalet->description = $request->input('description', $chalet->description);
        $chalet->address = $request->input('address', $chalet->address);
        $chalet->capacity = $request->input('capacity', $chalet->capacity);
        $chalet->rental_price = $request->input('rental_price', $chalet->rental_price);
        $chalet->available = $request->input('available', $chalet->available);
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Chalets/'.$chalet->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $chalet->photos === "") {
                    $chalet->photos = "$photo_full_name";
                } else {
                    $chalet->photos = $chalet->photos.","."$photo_full_name";
                }
            }
        }
        $chalet->update();
        return redirect()->route('edit-chalet', ['language'=>\App::getLocale(), 'id'=>$chalet->id]);
    }
}