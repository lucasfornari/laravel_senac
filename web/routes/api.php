<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

// use App\Http\Controllers\TicketController;
// use Illuminate\Support\Facades\Route;

// Route::post('/tickets/store', [TicketController::class, 'store']);
// Route::get('/tickets', [TicketController::class, 'index']);

