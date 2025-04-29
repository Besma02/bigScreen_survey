<?php

use App\Http\Controllers\AdminController;
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
    

});


Route::get('/survey/questions', [PublicSurveyController::class, 'questions']);
Route::post('/survey/submit', [PublicSurveyController::class, 'submit']);
Route::get('/survey/result/{token}', [PublicSurveyController::class, 'result']);
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'getDashboardData']);
    Route::get('/questions', [AdminController::class, 'getAllQuestions']);
    Route::get('/responses', [AdminController::class, 'getAllResponses']);
});


