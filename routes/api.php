<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\RestaurentsController;
use App\Http\Controllers\ChaletsController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TablesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/***************************************Facilities routes ************************************************** */

    Route::get('facility/getFacilities', [FacilitiesController::class, 'getFacilities']);
    Route::get('facility/getFacilityById/{id}', [FacilitiesController::class, 'getFacilityById']);
    Route::post('facility/addFacility', [FacilitiesController::class, 'addFacility']);
    Route::put('facility/updateFacility/{id}', [FacilitiesController::class, 'updateFacility']);
    Route::delete('facility/deleteFacility/{id}', [FacilitiesController::class, 'deleteFacility']);

/***************************************End Facilities routes ************************************************** */

/***************************************Hotels routes ************************************************** */

    Route::get('hotel/getHotels', [HotelsController::class, 'getHotels']);
    Route::get('hotel/getHotelById/{id}', [HotelsController::class, 'getHotelById']);
    Route::post('hotel/addHotel', [HotelsController::class, 'addHotel']);
    Route::put('hotel/updateHotel/{id}', [HotelsController::class, 'updateHotel']);
    Route::put('hotel/deletePhotoFromHotel/{hotelId}/{imageName}', [HotelsController::class, 'deletePhotoFromHotel']);
    Route::delete('hotel/deleteHotel/{id}', [HotelsController::class, 'deleteHotel']);

/***************************************End Hotels routes ************************************************** */

/***************************************Restaurents routes **************************************************/

    Route::get('restaurent/getRestaurents', [RestaurentsController::class, 'getRestaurents']);
    Route::get('restaurent/getRestaurentById/{id}', [RestaurentsController::class, 'getRestaurentById']);
    Route::post('restaurent/addRestaurent', [RestaurentsController::class, 'addRestaurent']);
    Route::put('restaurent/updateRestaurent/{id}', [RestaurentsController::class, 'updateRestaurent']);
    Route::put('restaurent/deletePhotoFromRestaurent/{restaurentId}/{imageName}', [RestaurentsController::class, 'deletePhotoFromRestaurent']);
    Route::delete('restaurent/deleteRestaurent/{id}', [RestaurentsController::class, 'deleteRestaurent']);

/***************************************End Restaurents routes **************************************************/

/*************************************** Chalet routes **************************************************/

    Route::get('chalet/getChalets', [ChaletsController::class, 'getChalets']);
    Route::get('chalet/getChaletById/{id}', [ChaletsController::class, 'getChaletById']);
    Route::post('chalet/addChalet', [ChaletsController::class, 'addChalet']);
    Route::put('chalet/updateChalet/{id}', [ChaletsController::class, 'updateChalet']);
    Route::put('chalet/deletePhotoFromChalet/{chaletId}/{imageName}', [ChaletsController::class, 'deletePhotoFromChalet']);
    Route::delete('chalet/deleteChalet/{id}', [ChaletsController::class, 'deleteChalet']);

/*************************************** End Chalet routes **********************************************/

/*************************************** Room routes **************************************************/

    Route::get('room/getRommsByHotelId/{hotelId}', [RoomsController::class, 'getRoomsByHotelId']);
    Route::get('room/getRoomById/{roomId}', [RoomsController::class, 'getRoomById']);
    Route::post('room/addRoom/{hotelId}', [RoomsController::class, 'addRoom']);
    Route::put('room/updateRoom/{roomId}', [RoomsController::class, 'updateRoom']);
    Route::put('room/deletePhotoFromRoom/{roomId}/{photoName}', [RoomsController::class, 'deletePhotoFromRoom']);
    Route::delete('room/deleteRoom/{roomId}', [RoomsController::class, 'deleteRoom']);

/*************************************** End Room routes **********************************************/

/*************************************** Reservation routes **************************************************/

    Route::post('reservation/reserveProperty/{online_payment}', [ReservationController::class, 'reserveProperty']);

/*************************************** End Reservation routes **********************************************/

/*************************************** Table routes **************************************************/

    Route::put('table/deletePhotoFromTable/{tableId}/{photoName}', [TablesController::class, 'deletePhotoFromTable']);
    Route::delete('table/deleteTable/{tableId}', [TablesController::class, 'delete']);

/*************************************** End Table routes **********************************************/