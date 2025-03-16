<?php

use Illuminate\Support\Facades\Route;

Route::get('/api/documentation', function () {
    return view('swagger.index');
})->name('swagger.docs');

Route::get('/api-docs.json', function () {
    $path = storage_path('api-docs/api-docs.json');
    if (!file_exists($path)) {
        return response()->json(['error' => 'Arquivo api-docs.json não encontrado'], 404);
    }
    return response()->file($path);
});
