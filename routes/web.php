<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.empty');
})->middleware(['auth', 'verified'])->name('admin');

Route::get('test', function() {
    $file = file_get_contents(base_path('success.xml'));

    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $file);
    $xml = new SimpleXMLElement($response);
    $body = $xml->xpath('//soapBody')[0];
    $array = json_decode(json_encode((array)$body), TRUE);


    $first_name = $array['ns1OTA_AirBookRS']['ns1AirReservation']['ns1TravelerInfo']['ns1AirTraveler'][0]['ns1PersonName']['ns1GivenName'] ?? null;
    $first_name = $first_name ? str($first_name)->squish()->toString() : null;
    dd($first_name);

    dd($array);
});

Route::post('register_user', [RegisteredUserController::class, 'store'])->name('register_user');
Route::post('login_user', [AuthenticatedSessionController::class, 'store'])->name('login_user');
Route::resource('reservations', ReservationController::class);





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
