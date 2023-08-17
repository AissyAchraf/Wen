<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ReservationController;
use App\Models\Transaction;

class StripeController extends Controller
{
    function process(Request $request) {
        $paymentMessage = '';
        if(!empty($_POST['stripeToken'])){
            
            // get token and user details
            $stripeToken  = $request->stripeToken;
            $customerName = $request->customerName;
            $customerEmail = $request->emailAddress;
            
            // $customerAddress = $request->customerAddress;
            // $customerCity = $request->customerCity;
            // $customerZipcode = $request->customerZipcode;
            // $customerState = $request->customerState;
            // $customerCountry = $request->customerCountry;
        
            $cardNumber = $request->cardNumber;
            $cardCVC = $request->cardCVC;
            $cardExpMonth = $request->cardExpMonth;
            $cardExpYear = $request->cardExpYear;    
            
            //set stripe secret key and publishable key
            $stripe = array(
                "secret_key"      => env('STRIPE_SECRET'),
                "publishable_key" => env('STRIPE_KEY')
            );    
            
            \Stripe\Stripe::setApiKey($stripe['secret_key']);    
            
            // add customer to stripe
            $customer = \Stripe\Customer::create(array(
                'name' => $customerName,
                'description' => 'test description',
                'email' => $customerEmail,
                'source'  => $stripeToken,
                "address" => []
            ));
            
            // item details for which payment made
            $reservationData = $request->session()->get('reservation_data');
            $propertyType = $reservationData['facilitieType'];
            $propertyData = $reservationData['facilitieData'];
            $propertyId = $propertyData->id;
            $price_currency = "ILS";
            $paid_amount = $reservationData['totalPrice']*100;
            $unit_price = $reservationData['unitPrice'];   
            
            // details for which payment performed
            $payDetails = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $paid_amount,
                'currency' => $price_currency,
                'description' => "Payment for reservation on Wen : ".$propertyType." reservation - ".$propertyData->name,
                'metadata' => array(
                    
                )
            ));   
            
            // get payment details
            $paymenyResponse = $payDetails->jsonSerialize();
            
            // check whether the payment is successful
            if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){
                
                // transaction details 
                $amountPaid = $paymenyResponse['amount'];
                $balanceTransaction = $paymenyResponse['balance_transaction'];
                $paidCurrency = $paymenyResponse['currency'];
                $paymentStatus = $paymenyResponse['status'];
                $paymentDate = date("Y-m-d H:i:s");        
            
            //insert tansaction details into database
            $transaction = Transaction::create([
                'cust_name' => $customerName,
                'cust_email' => $customerEmail,
                'card_num' => $cardNumber,
                'card_exp_month' => $cardExpMonth,
                'card_exp_year' => $cardExpYear,
                'property_type' => $propertyType,
                'property_id' => $propertyId,
                'price_currency' => $price_currency,
                'paid_amount' => $paid_amount,
                'unit_price' => $unit_price,
                'txn_id' => $balanceTransaction,
                'payment_status' => $paymentStatus,
                'created' => now(),
                'modified' => now(),
            ]);
            
            //if order inserted successfully
            if($transaction && $paymentStatus == 'succeeded'){
                    ReservationController::reserveProperty($request, true);
                    $paymentMessage = "The payment was successful!";
            } else{
                $paymentMessage = "failed";
            }
            
            } else{
                $paymentMessage = "failed";
            }
        } else{
            $paymentMessage = "failed";
        }
        $request->session()->put("message", $paymentMessage);
        return redirect()->back()->withInput();
    }
}
