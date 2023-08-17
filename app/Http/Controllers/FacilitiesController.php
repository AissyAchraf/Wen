<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilitiesController extends Controller
{
    function getFacilities() {
        $facilities = Facility::all();
        if(!$facilities) {
            return response()->json(['status'=>'failure', 'data'=>'No facility found'], 201);
        }
        return response()->json(['status'=>'success', 'data'=>$facilities], 200);
    }

    function getFacilityById($facility_id) {
        $facility = Facility::find($facility_id);
        if(!$facility) {
            return response()->json(['status'=>'failure', 'data'=>'No facility found'], 201);
        }
        return response()->json(['status'=>'success', 'data'=>$facility], 200);
    }

    function addFacility(Request $request) {
        $facility = Facility::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'photos' => $request->photos,
        ]);
        return response()->json(['status'=>'success', 'data'=>$facility], 200);
    }

    function updateFacility(Request $request, $facility_id) {
        $facility = Facility::find($facility_id);
        if(!$facility) {
            return response()->json(['status'=>'failure', 'data'=>'No facility found'], 201);
        }
        if($request->has('name')) {
            $facility->name = $request->name;
        }
        if($request->has('email')) {
            $facility->email = $request->email;
        }
        if($request->has('phone')) {
            $facility->phone = $request->phone;
        }
        if($request->has('description')) {
            $facility->description = $request->description;
        }
        if($request->has('address')) {
            $facility->address = $request->address;
        }
        if($request->has('photos')) {
            $facility->photos = $request->photos;
        }
        $facility->update();
        return response()->json(['status'=>'success', 'data'=>$facility], 200);
    }

    function deleteFacility($facility_id) {
        $facility = Facility::find($facility_id);
        if(!$facility) {
            return response()->json(['status'=>'failure', 'data'=>'No facility found'], 201);
        }
        $facility->delete();
        return response()->json(['status'=>'success', 'data'=>'Facility deleted successfully!'], 200);
    }
}
