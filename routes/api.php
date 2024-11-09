<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\studentController;

Route::get('/students', [studentController::class, 'getStudents']);
Route::get('/students/{id}', [studentController::class, 'getStudentByID']);

Route::post('/students', [studentController::class, 'addStudent']);
Route::patch('/students/{id}', function () {
    return 'updating student';
});
Route::delete('/students/{id}', function () {
    return 'deleting student';
});
