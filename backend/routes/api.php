<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicSurveyController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes PUBLIQUES
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Routes PROTEGÉES (authentification obligatoire)

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Exemples de routes sécurisées
    //Route::get('/survey/questions', [PublicSurveyController::class, 'questions'])->middleware('role:user');
    //Route::post('/survey/submit', [PublicSurveyController::class, 'submit'])->middleware('role:user');
    //Route::get('/survey/result/{token}', [PublicSurveyController::class, 'result'])->middleware('role:user');
    //Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});


Route::get('/survey/questions', [PublicSurveyController::class, 'questions'])->middleware('role:user');
Route::post('/survey/submit', [PublicSurveyController::class, 'submit']);
Route::get('/survey/result/{token}', [PublicSurveyController::class, 'result']);

