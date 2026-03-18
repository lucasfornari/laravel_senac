<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/contato', fn() => view('contato'));

Route::post('/produtos', function () {
    return response()->json('Produto cadastrado com sucesso');
});