<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortfolioController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// public routes:

Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login']);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/portfolios', [PortfolioController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::get('/portfolios/{id}', [PortfolioController::class, 'show']);
Route::get('/gigs', [GigController::class, 'index']);
Route::get('/gigs/{id}', [GigController::class, 'show']);
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/blogs/{id}', [BlogController::class, 'edit']);
Route::get('/users',[UserController::class, 'index']);
Route::get('/gigs/{id}', [GigController::class, 'edit']);

// protected routes:

Route::middleware(['auth:sanctum'])->group(function(){   
    
//Gig related routes:

Route::post('/gigs', [GigController::class, 'store']);
Route::post('/gigs/{id}', [GigController::class, 'update']);
Route::delete('/gigs/{id}', [GigController::class, 'destroy']);

//Blog related routes:
Route::post('/blogs', [BlogController::class, 'store']);
Route::post('/blogs/{id}', [BlogController::class, 'update']);
Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

//Portfolio related routes:
Route::post('/portfolios', [PortfolioController::class, 'store']);
Route::post('/portfolios/{id}', [PortfolioController::class, 'update']);
Route::delete('/portfolios/{id}', [PortfolioController::class, 'destroy']);

//Message related routes:

Route::get('/messages', [MessageController::class, 'index']);

Route::delete('/messages/{id}', [MessageController::class, 'destroy']);

//Register related routes:
Route::post('/logout',[UserController::class, 'logout']);
Route::get('/loggedUser',[UserController::class, 'logged_user']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

});