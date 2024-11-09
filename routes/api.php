<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\studentController;

Route::get('/students', [studentController::class, 'getStudents']);
Route::get('/students/{id}', [studentController::class, 'getStudentByID']);

Route::post('/students', [studentController::class, 'addStudent']);

Route::put('/students/{id}', [studentController::class, 'updateStudent']);
Route::patch('/students/{id}', [studentController::class, 'partialUpdateStudent']);

Route::delete('/students/{id}', [studentController::class, 'deleteStudent']);
