<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorsController;
use App\Http\Controllers\Api\AuthorTicketsController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::get('/', function () {
//     return response()->json([
//         'massage' => 'hellow api'
//     ],200);
// });

Route::post('/login', [AuthController::class , 'login']);

Route::post('/register', [AuthController::class , 'register']);



//api/tickets/{id}
Route::middleware('auth:sanctum')->apiResource('tickets' , TicketController::class);

Route::middleware('auth:sanctum')->apiResource('authors' , AuthorsController::class);


Route::middleware('auth:sanctum')->apiResource('authors.tickets' , AuthorTicketsController::class);


Route::middleware('auth:sanctum')->post('/logout' , [AuthController::class , 'logout']);

