<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Hotel;
use App\Models\Chalet;
use App\Models\Restaurent;
use App\Models\Subscription;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Case of property registration
        if(array_key_exists('property_type', $data)) {
            return Validator::make($data, [
                'property_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone' => ['required', 'string', 'max:13'],
                'property_type' => ['required', 'string', Rule::in(['hotel', 'chalet', 'restaurant'])],
                'address' => ['required', 'string', 'max:255'],
                'latitude' => ['required', 'numeric'],
                'longitude' => ['required', 'numeric'],
            ]);
        }
        // Case of client registration
        else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(array_key_exists('property_type', $data)) {
            $savedUser = User::create([
                'name' => $data['email'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'manager',
            ]);
            if($data['property_type'] == "hotel") {
                $property = Hotel::create([
                    'name' => $data['property_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'user_manager' => $savedUser->id,
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'status' => false,
                ]);
                Subscription::create([
                    'type_id' => 1,
                    'start_date' => now(),
                    'status' => 1,
                    'hotel_id' => $property->id,
                ]);
            }
            elseif ($data['property_type'] == "chalet") {
                $property = Chalet::create([
                    'name' => $data['property_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'user_manager' => $savedUser->id,
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'status' => false,
                ]);
                Subscription::create([
                    'type_id' => 1,
                    'start_date' => now(),
                    'status' => 1,
                    'chalet_id' => $property->id,
                ]);
            }
            elseif ($data['property_type'] == "restaurant") {
                $property = Restaurent::create([
                    'name' => $data['property_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'user_manager' => $savedUser->id,
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'status' => false,
                ]);
                Subscription::create([
                    'type_id' => 1,
                    'start_date' => now(),
                    'status' => 1,
                    'restaurant_id' => $property->id,
                ]);
            }
            return $savedUser;
        }
        // Case of client registration
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'user',
            'password' => Hash::make($data['password']),
        ]);
    }
}
