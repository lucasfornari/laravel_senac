<?php

use Illuminate\Support\Facades\Route;

Route::post('/produtos', function() {
    return response()-> json('Produto cadastrado com sucesso');
});