<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use View;
use Auth;

class ReservationController extends Controller
{

    public function traiterReservation(Request $request)
    {
        // Valider les données du formulaire de réservation
        $request->validate([
            'checkin' => 'required|date|after:yesterday',
            'checkout' => 'required|date|after:checkin',
            'guests' => 'required|integer|min:1',
        ]);

        // Stocker les données de réservation dans la session
        $reservationData = [
            'checkin' => $request->input('checkin'),
            'checkout' => $request->input('checkout'),
            'guests' => $request->input('guests'),
        ];

        $request->session()->put('reservation_data', $reservationData);

        // Rediriger vers la page de paiement
        return redirect()->route('page-paiement');
    }
    
    function paymentPage(Request $request) {
        if($request->session()->has('reservation_data')) {
            $reservationData = $request->session()->get('reservation_data');
            $facilitie = $reservationData['facilitieData'];
            return View::make("site.ReservationPage")->with($reservationData);
        } else {
            return redirect()->back()->withErrors(['notAvailableMessage'=>'Something wents wrong. Please try again!'])->withInput();
        }
    }

    static function reserveProperty(Request $request, $online_payment) {
        $userId = Auth::id();
        if($request->session()->has('reservation_data')) {
            $reservationData = $request->session()->get('reservation_data');
            $propertyData = $reservationData['facilitieData'];
            $propertyId = $propertyData->id;
            $reservation = Reservation::create([
                'client_id' => $userId,
                'start_date' => $reservationData['checkin'],
                'end_date'=> $reservationData['checkout'],
                'amount'=> $reservationData['totalPrice'],
                'online_payement' => $online_payment,
                'status' => "confirmed",
                'room_id' => $reservationData['facilitieType'] === "Room" ? $propertyId : null,
                'table_id' => $reservationData['facilitieType'] === "Table" ? $propertyId : null,
                'chalet_id' => $reservationData['facilitieType'] === "Chalet" ? $propertyId : null,
            ]);
            return response()->json(["status"=>"success", "data"=>$reservation], 200);
        }
        return response()->json(["status"=>"failed", "data"=>"No reservation data found"], 404);
    }
}
