<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/teste', fn() => view('teste'));

Route::post('/produtos', function () {
    $produtos = [
        ['id' => 1, 'nome' => 'Produto A', 'valor' => 29.90],
        ['id' => 2, 'nome' => 'Produto B', 'valor' => 49.90],
        ['id' => 3, 'nome' => 'Produto C', 'valor' => 79.90],
    ];
    return response()->json($produtos);
});