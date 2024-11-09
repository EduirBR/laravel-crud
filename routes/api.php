<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/students', function () {
    return 'listing students';
});
Route::get('/students/{id}', function () {
    return 'get one student';
});
Route::post('/students', function () {
    return 'creating student';
});
Route::patch('/students/{id}', function () {
    return 'updating student';
});
Route::delete('/students/{id}', function () {
    return 'deleting student';
});
