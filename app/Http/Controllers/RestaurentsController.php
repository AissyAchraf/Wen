<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurent;
use App\Models\Table;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use DateTime;

class RestaurentsController extends Controller
{
    public function getRestaurents()
    {
        $restaurents = Restaurent::all();
        if ($restaurents->isEmpty()) {
            return response()->json(['status' => 'failure', 'data' => 'No Restaurent found'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $restaurents], 200);
    }

    function getRestaurent(Request $request, $locale, $restaurant_id) {
        $request->session()->forget('reservation_data');
        $request->session()->forget('number_hours');
        $restaurant = Restaurent::find($restaurant_id);
        if(!$restaurant)
            return response()->json(["status"=>"failure", "data"=>"Restaurant not found!"], 404);
        if ($request->date != null && $request->checkinHour != null && $request->checkoutHour != null) {
            $checkinDate = $request->input('date') . ' ' . $request->input('checkinHour');
            $checkoutDate = $request->input('date') . ' ' . $request->input('checkoutHour');

            $availableTables = Table::where('restaurent_id', $restaurant->id)->whereDoesntHave('reservations', function ($query) use ($checkinDate, $checkoutDate) {
                // Check for overlapping reservations
                $query->where(function ($query) use ($checkinDate, $checkoutDate) {
                    $query->whereBetween('start_date', [$checkinDate, $checkoutDate])
                    ->orWhereBetween('end_date', [$checkinDate, $checkoutDate]);
                });
            })
            ->when($request->guests != null, function($q) use ($request) {
                return $q->where('capacity', $request->guests);
            })
            ->paginate(5)->appends($request->all());

            $restaurant->tables = $availableTables;
            
            // calculate the number of nights
            $datetime1 = new DateTime($checkinDate);
            $datetime2 = new DateTime($checkoutDate);
            $interval = $datetime1->diff($datetime2);
            $hours = $interval->format('%h');
            $minutes = $interval->format('%i');
            $hours = $hours + ($minutes / 60 > 0.5 ? 1 : 0);

            $request->session()->put('number_hours', $hours);
        } else {
            $restaurant->tables = DB::table("tables")
            ->where('restaurent_id', $restaurant->id)
            ->where('is_available', 1)
            ->paginate(5)->appends($request->all());
        }
        return view('site.Restaurents.restaurantDetails', compact('restaurant'));
    }

    public function getRestaurentsList(Request $request)
    {
        if ($request->checkoutDate != null && $request->checkinDate != null) {
            $restaurents = DB::table("restaurents")
            ->where('restaurents.status', 1)
            ->leftJoin('tables', function ($join) use ($request) {
                $join->on('restaurents.id', '=', 'tables.restaurent_id');
            })
            ->leftJoin('reservations', function ($join) use ($request) {
                $join->on('tables.id', '=', 'reservations.table_id')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('reservations.start_date', [$request->checkinDate, $request->checkoutDate])
                        ->orWhereBetween('reservations.end_date', [$request->checkinDate, $request->checkoutDate])
                        ->orWhereNull('reservations.id');
                });
            })
            ->whereNull('reservations.id')
            ->when($request->price_min != null && $request->price_max != null, function($q) use ($request) {
                return $q->whereBetween('tables.price', [$request->price_min, $request->price_max]);
            })
            ->select('restaurents.*')
            ->groupBy('restaurents.id')
            ->when($request->guests != null, function($q) use ($request) {
                return $q->where('capacity', '>=', $request->guests);
            })
            ->paginate(5)->appends($request->all());
        } else {
            $restaurents = DB::table("restaurents")
            ->where('restaurents.status', 1)
            ->leftJoin('tables', function ($join) use ($request) {
                $join->on('restaurents.id', '=', 'tables.restaurent_id');
            })
            ->when($request->price_min != null && $request->price_max != null, function($q) use ($request) {
                return $q->whereBetween('tables.price', [$request->price_min, $request->price_max]);
            })
            ->select('restaurents.*')
            ->groupBy('restaurents.id')
            ->when($request->guests != null, function($q) use ($request) {
                return $q->where('capacity', '>=', $request->guests);
            })
            ->paginate(5)->appends($request->all());
        }
        return view('site.Restaurents.restaurentsList', compact('restaurents'));
    }

    public function getRestaurentById($restaurent_id)
    {
        $restaurent = Restaurent::find($restaurent_id);
        if (!$restaurent) {
            return response()->json(['status' => 'failure', 'data' => 'No Restaurent found'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $restaurent], 200);
    }

    public function addRestaurent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'photos' => 'required|file[]',
            'capacity' => 'required|integer',
            'cuisine' => 'required|string',
        ]);
        $restaurent = Restaurent::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
            'photos' => "",
            'capacity' => $request->input('capacity'),
            'cuisine' => $request->input('cuisine'),
        ]);
        $uploadedPhotos = $request->file('photos');
        foreach ($uploadedPhotos as $i => $photo) {
            $ext = $photo->getClientOriginalExtension();
            $photo_full_name = date('YmdHis').".".$i.".".$ext;
            $destinationPath = '/images/Restaurents/'.$restaurent->id;
            $photo->move(public_path($destinationPath), $photo_full_name);
            if($i == 0 && $restaurent->photos === "") {
                $restaurent->photos = "$photo_full_name";
            } else {
                $restaurent->photos = $restaurent->photos.","."$photo_full_name";
            }
        }
        $restaurent->update();
        return response()->json(['status' => 'success', 'data' => $restaurent], 201);
    }

    public function updateRestaurent(Request $request, $restaurent_id)
    {
        $restaurent = Restaurent::find($restaurent_id);
        if (!$restaurent) {
            return response()->json(['status' => 'failure', 'data' => 'No Restaurent found'], 404);
        }
        $restaurent->name = $request->input('name', $restaurent->name);
        $restaurent->email = $request->input('email', $restaurent->email);
        $restaurent->phone = $request->input('phone', $restaurent->phone);
        $restaurent->description = $request->input('description', $restaurent->description);
        $restaurent->address = $request->input('address', $restaurent->address);
        $restaurent->capacity = $request->input('capacity', $restaurent->capacity);
        $restaurent->cuisine = $request->input('cuisine', $restaurent->cuisine);
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Restaurents/'.$restaurent->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $restaurent->photos === "") {
                    $restaurent->photos = "$photo_full_name";
                } else {
                    $restaurent->photos = $restaurent->photos.","."$photo_full_name";
                }
            }
        }
        $restaurent->update();
        return response()->json(['status' => 'success', 'data' => $restaurent], 200);
    }

    public function deleteRestaurent($restaurent_id)
    {
        $restaurent = Restaurent::find($restaurent_id);
        if (!$restaurent) {
            return response()->json(['status' => 'failure', 'data' => 'No restaurent found'], 404);
        }
        if($restaurent->photos !== "") {
            try {
                $imagesList = explode(",", $restaurent->photos);
                foreach($imagesList as $image) {
                    $path = "/images/Restaurents/".$restaurent->id."/".$image;
                    File::delete(public_path($path));
                }
                File::deleteDirectory(public_path("images/Restaurents/".$restaurent->id));
            } catch (Exception $e) {
                return response()->json(["status"=>"failure", "data"=>"We could not delete the restaurent, something wents wrong!"], 201);
            }
        }
        $restaurent->delete();
        return response()->json(['status' => 'success', 'data' => 'Restaurent deleted successfully!'], 200);
    }

    function deletePhotoFromRestaurent($restaurentId, $image_name) {
        $restaurent = Restaurent::find($restaurentId);
        if(!$restaurent) {
            return response()->json(['status'=>'failure', 'data'=>"No Restaurent found!"], 404);
        }
        $imagesList = explode(",", $restaurent->photos);
        $index = array_search($image_name, $imagesList);
        if ($index !== false) {
            unset($imagesList[$index]);
        }
        try {
            $path = "/images/Restaurents/".$restaurent->id."/".$image_name;
            File::delete(public_path($path));
        } catch (Exception $e) {
            return response()->json(["status"=>"failure", "message"=>"We could not delete the image, something wents wrong!"], 201);
        }
        $restaurent->photos = implode(",", $imagesList);
        $restaurent->update();
        return response()->json(["status"=>"success", "data"=>"Image deleted successfully!"],200);
    }

    function edit($locale, $restaurant_id) {
        $restaurant = Restaurent::find($restaurant_id);
        return view('site.Restaurents.updateRestaurant', compact('restaurant'));
    }

    public function update(Request $request, $locale, $restaurent_id)
    {
        $restaurent = Restaurent::find($restaurent_id);
        if (!$restaurent) {
            return response()->json(['status' => 'failure', 'data' => 'No Restaurent found'], 404);
        }
        $restaurent->name = $request->input('name', $restaurent->name);
        $restaurent->email = $request->input('email', $restaurent->email);
        $restaurent->phone = $request->input('phone', $restaurent->phone);
        $restaurent->description = $request->input('description', $restaurent->description);
        $restaurent->address = $request->input('address', $restaurent->address);
        $restaurent->capacity = $request->input('capacity', $restaurent->capacity);
        $restaurent->cuisine = $request->input('cuisine', $restaurent->cuisine);
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Restaurents/'.$restaurent->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $restaurent->photos === "") {
                    $restaurent->photos = "$photo_full_name";
                } else {
                    $restaurent->photos = $restaurent->photos.","."$photo_full_name";
                }
            }
        }
        $restaurent->update();
        return redirect()->route('edit-restaurant', ['language'=>\App::getLocale(), 'id'=>$restaurent->id]);
    }
}

