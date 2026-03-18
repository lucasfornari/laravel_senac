<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/produtos/{codigo}', function (Request $request, $codigo) {

    $produtos = [
        1 => ['nome' => 'Fone de Ouvido Bluetooth', 'valor' => 79.90],
        2 => ['nome' => 'Mouse Sem Fio', 'valor' => 49.90],
        3 => ['nome' => 'Teclado Mecânico', 'valor' => 249.90],
        4 => ['nome' => 'Monitor 24 polegadas', 'valor' => 599.90],
        5 => ['nome' => 'Webcam Full HD', 'valor' => 149.90],
        6 => ['nome' => 'Mousepad Grande', 'valor' => 59.90],
        7 => ['nome' => 'Hub USB 3.0', 'valor' => 89.90],
        8 => ['nome' => 'Suporte para Notebook', 'valor' => 119.90],
        9 => ['nome' => 'Cabo HDMI 2.1', 'valor' => 39.90],
        10 => ['nome' => 'Carregador Rápido 65W', 'valor' => 169.90],
    ];

    return response()->json([
        'produto' => $produtos[$codigo] ?? 'Produto não encontrado'
    ], 201);
});