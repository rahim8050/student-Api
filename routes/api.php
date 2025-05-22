<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route::get('student', function () {
//     return "i am learning api using laravel";
// });
// Route::get('what', function () {
//     return view('welcome');
// });
Route::get('student',[StudentController::class, 'index'])->name('index');

Route::Post('student',[StudentController::class,'store'])->name('store');

Route::put('student/update/{id}',[StudentController::class,'update'])->name('update');
// Route::apiResource('student', StudentController::class)->only([
//     'index', 'store', 'show', 'update', 'destroy'
// ]);
