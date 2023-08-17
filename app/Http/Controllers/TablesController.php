<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Restaurent;
use App\Models\Reservation;
use View;
use File;
use DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TablesController extends Controller
{
    function getTablesByRestaurant(Request $request, $locale, $restaurant_id) {
        $tables = Table::where('restaurent_id', $restaurant_id)->paginate(5)->appends($request->all());
        $restaurant = Restaurent::find($restaurant_id);
        $data = [
            'tables' => $tables,
            'restaurant' => $restaurant,
        ];
        return View::make('site.Restaurents.tablesList')->with($data);
    }

    function addTableForm($locale, $restaurant_id) {
        $restaurant = Restaurent::find($restaurant_id);
        return view('site.Restaurents.addTableForm', compact('restaurant'));
    }

    function addTable(Request $request, $locale) {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer',
            'price' => 'required|float',
            'photos' => 'required|mimes:jpg,jpeg,png,bmp,webp|max:20000',
            'capacity' => 'required|integer|min=1',
        ]);
        $table = Table::create([
            'number' => $request->number,
            'price' => $request->price,
            'is_available' => true,
            'restaurent_id' => $request->restaurant_id,
            'photos' => "",
        ]);

        $uploadedPhotos = $request->file('photos');

            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Tables/'.$table->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $table->photos === "") {
                    $table->photos = "$photo_full_name";
                } else {
                    $table->photos = $table->photos.","."$photo_full_name";
                }
            }
            $table->update();
        return response()->json(['status'=>'success', 'data'=>$table], 200);
    }

    function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer',
            'price' => 'required|float',
            'photos' => 'required|file[]',
            'capacity' => 'required|integer|min=1',
        ]);
        $table = Table::create([
            'number' => $request->number,
            'price' => $request->price,
            'is_available' => true,
            'capacity' => $request->capacity,
            'restaurent_id' => $request->restaurant_id,
            'photos' => "",
        ]);

        $uploadedPhotos = $request->file('photos');

            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Tables/'.$table->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $table->photos === "") {
                    $table->photos = "$photo_full_name";
                } else {
                    $table->photos = $table->photos.","."$photo_full_name";
                }
            }
            $table->update();
        
        return redirect()->route('restaurant-tables', ['language'=>\App::getLocale(), 'id'=>$table->restaurent_id]);    
    }

    // function processTableReservation(Request $request, $locale, $table_id) {
    //     if($request->date == null || $request->checkinHour == null || $request->checkoutHour == null) {
    //         return redirect()->back()->withErrors(['notAvailableMessage'=>'You have to choose a range of time.'])->withInput();
    //     }
    //     $checkinDate = $request->input('date') . ' ' . $request->input('checkinHour');
    //     $checkoutDate = $request->input('date') . ' ' . $request->input('checkoutHour');
    //     //Check if available
    //     $table = Table::find($table_id);
    //     if(!$table)
    //         return redirect()->back()->withErrors(['notAvailableMessage'=>'This table is not available.'])->withInput();
    //         $reservation = DB::table('reservations')
    //         ->where('table_id', $table_id)
    //         ->where(function ($query) use ($checkinDate, $checkoutDate) {
    //             $query->whereBetween('start_date', [$checkinDate, $checkoutDate])
    //                   ->orWhereBetween('end_date', [$checkinDate, $checkoutDate]);
    //         })
    //         ->get()
    //         ->first();
    //     if($reservation) {
    //         return redirect()->back()->withErrors(['notAvailableMessage'=>'This table is not available for your time range on Wen. Try new time range to check availability.'])->withInput();
    //     }

    //     // calculate number of nights
    //     $datetime1 = new DateTime($checkinDate);
    //     $datetime2 = new DateTime($checkoutDate);
    //     $interval = $datetime1->diff($datetime2);
    //     $hours = $interval->format('%h');
    //     $minutes = $interval->format('%i');
    //     $hours = $hours + ($minutes / 60 > 0.5 ? 1 : 0);

    //     $reservationData = [
    //         'bookingDetails' => $hours.' hours',
    //         'facilitieType' => 'Table',
    //         'facilitieData' => $table,
    //         'checkin' => $checkinDate,
    //         'checkout' => $checkoutDate,
    //         'guests' => $request->input('guests'),
    //         'unitPrice' => $table->price,
    //         'totalPrice' => $hours*$table->price,
    //     ];
    //     $request->session()->put('reservation_data', $reservationData);
    //     return redirect()->route('reserve', ['language'=>\App::getLocale()]);
    // }

    function processTableReservation(Request $request, $locale) {
        if($request->date == null || $request->checkinHour == null || $request->checkoutHour == null) {
            return redirect()->back()->withErrors(['notAvailableMessage'=>'You have to choose a range of time.'])->withInput();
        }
        $checkinDate = $request->input('date') . ' ' . $request->input('checkinHour');
        $checkoutDate = $request->input('date') . ' ' . $request->input('checkoutHour');
        //Check if available
        $table = Table::find($request->table_id);
        if(!$table)
            return redirect()->back()->withErrors(['notAvailableMessage'=>'This table is not available.'])->withInput();
            $reservation = DB::table('reservations')
            ->where('table_id', $request->table_id)
            ->where(function ($query) use ($checkinDate, $checkoutDate) {
                $query->whereBetween('start_date', [$checkinDate, $checkoutDate])
                      ->orWhereBetween('end_date', [$checkinDate, $checkoutDate]);
            })
            ->get()
            ->first();
        if($reservation) {
            return redirect()->back()->withErrors(['notAvailableMessage'=>'This table is not available for your time range on Wen. Try new time range to check availability.'])->withInput();
        }

        // calculate number of nights
        $datetime1 = new DateTime($checkinDate);
        $datetime2 = new DateTime($checkoutDate);
        $interval = $datetime1->diff($datetime2);
        $hours = $interval->format('%h');
        $minutes = $interval->format('%i');
        $hours = $hours + ($minutes / 60 > 0.5 ? 1 : 0);

        $reservationData = [
            'bookingDetails' => $hours.' hours',
            'facilitieType' => 'Table',
            'facilitieData' => $table,
            'checkin' => $checkinDate,
            'checkout' => $checkoutDate,
            'guests' => $request->input('guests'),
            'unitPrice' => $table->price,
            'totalPrice' => $hours*$table->price,
        ];

        $userId = Auth::id();
        Reservation::create([
            'client_id' => $userId,
            'start_date' => $checkinDate,
            'end_date'=> $checkoutDate,
            'amount'=> $hours*$table->price,
            'online_payement' => '0',
            'status' => "pending",
            'room_id' => null,
            'table_id' => $reservationData['facilitieType'] === "Table" ? $request->table_id : null,
            'chalet_id' => null,
        ]);
        $request->session()->put('reservation_sent', "Thank you for your reservation request! Please note that your reservation is not confirmed until you receive a confirmation from restaurant.");
        return redirect()->route('restaurant', ['language'=>\App::getLocale(), 'id'=>$table->restaurent_id]);
    }

    function edit($locale, $table_id) {
        $table = Table::find($table_id);
        return view('site.Restaurents.updateTableForm', compact('table'));
    }

    function update(Request $request, $locale, $table_id) {
        $table = Table::find($table_id);
        if(!$table) {
            return response()->json(['status'=>'failure', 'data'=>'Table not found!']);
        }
        if($request->has('number')) {
            $table->number = $request->number;
        }
        if($request->has('price')) {
            $table->price = $request->price;
        }
        if($request->has('is_available')) {
            $table->is_available = $request->is_available;
        }
        if($request->has('capacity')) {
            $table->capacity = $request->capacity;
        }
        if($request->hasFile('photos')) {
            $uploadedPhotos = $request->file('photos');
            foreach ($uploadedPhotos as $i => $photo) {
                $ext = $photo->getClientOriginalExtension();
                $photo_full_name = date('YmdHis').".".$i.".".$ext;
                $destinationPath = '/images/Tables/'.$table->id;
                $photo->move(public_path($destinationPath), $photo_full_name);
                if($i == 0 && $table->photos === "") {
                    $table->photos = "$photo_full_name";
                } else {
                    $table->photos = $table->photos.","."$photo_full_name";
                }
            }
        }
        $table->save();
        return redirect()->route('restaurant-tables', ['language'=>\App::getLocale(), 'id'=>$table->restaurent_id]);    
    }

    function deletePhotoFromTable($table_id, $image_name) {
        $table = Table::find($table_id);
        if(!$table) {
            return response()->json(['status'=>'failure', 'data'=>"No Room found!"], 404);
        }
        $imagesList = explode(",", $table->photos);
        $index = array_search($image_name, $imagesList);
        if ($index !== false) {
            unset($imagesList[$index]);
        }
        try {
            $path = "/images/Tables/".$table->id."/".$image_name;
            File::delete(public_path($path));
        } catch (Exception $e) {
            return response()->json(["status"=>"failure", "message"=>"We could not delete the image, something wents wrong!"], 404);
        }
        $table->photos = implode(",", $imagesList);
        $table->update();
        return response()->json(["status"=>"success", "data"=>"Image deleted successfully!"],200);
    }

    function delete($table_id) {
        $table = Table::find($table_id);
        if(!$table) {
            return response()->json(['status'=>'failure', 'data'=>"No Room found!"], 404);
        }
        if($table->photos !== "") {
            try {
                $imagesList = explode(",", $table->photos);
                foreach($imagesList as $image) {
                    $path = "/images/Tables/".$table->id."/".$image;
                    File::delete(public_path($path));
                }
                File::deleteDirectory(public_path("images/Tables/".$table->id));
            } catch (Exception $e) {
                return response()->json(["status"=>"failure", "data"=>"We could not delete the room, something wents wrong!"], 201);
            }
        }
        $table->delete();
        return  response()->json(['status'=>'success', 'data'=>"Table deleted successfuly!"], 200);
    }
}
