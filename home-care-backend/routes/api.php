<?php

use App\Http\Controllers\IncidentDetailController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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
Route::get('/setup', [AuthorizationController::class, 'setup']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::get('/countries', [ApiAuthController::class, 'countries']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/resend-verification-code', [ApiAuthController::class, 'sendEmailCode']);
    Route::post('/verify-email', [ApiAuthController::class, 'verifyEmail']);

    Route::post('/send-otp', [VerificationDetailController::class, 'sendOtp']);
    Route::post('/submit-verify-phone', [VerificationDetailController::class, 'verifyPhone']);
    Route::get('/verify-phone/{user}', [VerificationDetailController::class, 'verifyPhonePage'])->name('user.verify-phone');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('home-care')->group(function () {
        Route::post('/create-incident', [IncidentController::class, 'createIncident']);
        Route::get('/view-incidents', [IncidentController::class, 'viewIncidents']);
        Route::get('/my-incidents-details', [IncidentController::class, 'viewYourIncidents']);
        Route::get('/single-incident/{slug}', [IncidentController::class, 'singleIncident']);
        Route::post('/submit-incident-log/{slug}', [IncidentController::class, 'incidentLog']);
    });

    Route::prefix('client')->group(function () {
        Route::get('/select-incidents', [IncidentController::class, 'selectIncidents']);
        Route::post('/upload-incident', [IncidentDetailController::class, 'clientUploadIncident']);
        Route::get('/view-incident-log', [IncidentDetailController::class, 'viewIncidentLog']);
    });

});

