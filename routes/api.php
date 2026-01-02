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


Route::middleware('auth:sanctum')->group(function(){


        //api/tickets/{id}
    Route::apiResource('tickets' , TicketController::class)->except(['update']);
    Route::put('tickets/{ticket}' , [TicketController::class, 'replace']);
    Route::patch('tickets/{ticket}' , [TicketController::class, 'update']);


    Route::apiResource('authors' , AuthorsController::class);


    Route::apiResource('authors.tickets' , AuthorTicketsController::class)->except(['update']);

    Route::put('authors/{author}/tickets/{ticket}' , [AuthorTicketsController::class, 'replace']);
    
     Route::patch('authors/{author}/tickets/{ticket}' , [AuthorTicketsController::class, 'update']);


    Route::post('/logout' , [AuthController::class , 'logout']);


});


