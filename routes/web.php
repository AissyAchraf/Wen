<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\ChaletsController;
use App\Http\Controllers\RestaurentsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ContactController;

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckHotelManager;
use App\Http\Middleware\CheckRoomManager;
use App\Http\Middleware\CheckChaletManager;
use App\Http\Middleware\CheckRestaurantManager;
use App\Http\Middleware\CheckTableManager;
use App\Http\Middleware\CheckHotelSubscription;
use App\Http\Middleware\CheckRoomSubscription;
use App\Http\Middleware\CheckChaletSubscription;
use App\Http\Middleware\CheckRestaurantSubscription;
use App\Http\Middleware\CheckTableSubscription;
use App\Http\Middleware\CheckChatRoles;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/en');

Route::get('chatify/{id}', 'Chatify\Http\Controllers\MessagesController@index')
    ->middleware(CheckChatRoles::class)->name('start-conversation');

Route::group(['prefix' => '{language}'], function () {

    Route::get('/', [SiteController::class,'index'])->name('index');

    Route::get('/u/terms', [SiteController::class,'termsConditionsPage'])->name('terms');
    Route::get('/u/contact-us', [ContactController::class,'contactUsPage'])->name('contact-us');
    Route::post('/u/contact-us', [ContactController::class, 'store'])->name('contact.us.store');

    Route::middleware([CheckHotelManager::class])->group(function () {
        Route::get('/m/hotel/edit/{id}', [HotelsController::class,'edit'])->name('edit-hotel');
        Route::put('/m/hotel/update/{id}', [HotelsController::class,'update'])->name('update-hotel');
        Route::middleware([CheckHotelSubscription::class])->group(function () {
            Route::get('/m/hotel/{id}/rooms', [RoomsController::class,'roomsByHotel'])->name('hotel-rooms');
            Route::get('/m/hotel/{id}/add-new-room', [HotelsController::class, 'addRoom'])->name('add-room');
            Route::post('/m/room/create/{id}', [RoomsController::class, 'create'])->name('create-room');
        });
    });

    Route::get('/u/hotels', [HotelsController::class,'getHotelsList'])->name('hotels');
    Route::get('/u/hotel/{id}', [HotelsController::class,'getHotel'])->name('hotel');
    

    Route::get('/u/chalets', [ChaletsController::class,'getChaletsList'])->name('chalets');
    Route::get('/u/chalet/{id}', [ChaletsController::class,'getChalet'])->name('chalet');

    Route::middleware([CheckChaletManager::class])->group(function () {
        Route::put('/m/chalet/update/{id}', [ChaletsController::class,'update'])->name('update-chalet');
        Route::get('/m/chalet/edit/{id}', [ChaletsController::class,'edit'])->name('edit-chalet');
    });

    Route::get('/u/process-room-reservation/{room_id}', [RoomsController::class,'processRoomReservation'])->name('processRoomReservation');

    Route::get('/u/restaurents', [RestaurentsController::class,'getRestaurentsList'])->name('restaurents');
    Route::get('/u/restaurent/{id}', [RestaurentsController::class,'getRestaurent'])->name('restaurant');

    Route::middleware([CheckRestaurantManager::class])->group(function () {
        Route::get('/m/restaurent/edit/{id}', [RestaurentsController::class,'edit'])->name('edit-restaurant');
        Route::put('/m/restaurent/update/{id}', [RestaurentsController::class,'update'])->name('update-restaurant');
        Route::middleware([CheckRestaurantSubscription::class])->group(function () {
            Route::get('/m/restaurant/{id}/tables', [TablesController::class,'getTablesByRestaurant'])->name('restaurant-tables');
            Route::get('/m/restaurant/{id}/add-new-table', [TablesController::class,'addTableForm'])->name('add-table');
            Route::post('/m/table/create/{id}', [TablesController::class,'create'])->name('create-table');
        });
    });

    Route::middleware([CheckTableManager::class, CheckTableSubscription::class])->group(function () {
        Route::get('/m/table/edit/{id}', [TablesController::class,'edit'])->name('edit-table');
        Route::put('/m/table/update/{id}', [TablesController::class,'update'])->name('update-table');
    });

    // Route::get('/u/process-table-reservation', [TablesController::class,'processTableReservation'])->name('processTableReservation');
    Route::post('/u/process-table-reservation', [TablesController::class,'processTableReservation'])->name('processTableReservation');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/reserve', [ReservationController::class, 'paymentPage'])->name('reserve')->middleware('auth');
    Route::post('/transaction-process', [StripeController::class, 'process'])->name('process')->middleware('auth');

    Route::get('/u/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');

    Route::get('/u/beginning-registration', [SiteController::class, 'beginningRegistration'])->name('beginning-registration');
    Route::get('/u/business-registration', [SiteController::class, 'businessRegistration'])->name('business-registration');
    Route::get('/u/client-registration', [SiteController::class, 'clientRegistration'])->name('client-registration');

    Route::middleware([CheckRoomManager::class, CheckRoomSubscription::class])->group(function () {
        Route::delete('/m/room/delete/{id}', [SiteController::class, 'clientRegistration'])->name('delete-room');
        Route::get('/m/room/edit/{id}', [RoomsController::class, 'edit'])->name('edit-room');
        Route::put('/m/room/update/{id}', [RoomsController::class, 'update'])->name('update-room');
    });
});