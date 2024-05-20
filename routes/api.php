<?php

use App\Http\Controllers;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HistoriasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register',[Controllers\AuthController::class,'register']);
Route::get('/register', function () {
    return response()->json(['message' => ['type' => 'error', 'text' => 'Acceso no autorizado']], 401);
})->name('register');
Route::post('/login', [Controllers\AuthController::class, 'login'])->name('api.login');
Route::get('/login', function () {
    return response()->json(['message' => ['type' => 'error', 'text' => 'Acceso no autorizado']], 401);
})->name('login');

Route::get('/users', [UsersController::class,'index']);
Route::get('/users/{id}', [UsersController::class,'show']);
Route::post('/users',[UsersController::class,'store']);
Route::patch('/users/{id}', [UsersController::class,'update']);
Route::delete('/users/{id}', [UsersController::class,'destroy']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [Controllers\AuthController::class,'user']);
    Route::post('/logout', [Controllers\AuthController::class, 'logout'])->name('api.logout');
    Route::get('/pacientes', [UsersController::class,'findPacientes']);
    Route::put('/users/{id}', [UsersController::class,'updatePartial']);
    Route::get('/historia', [HistoriasController::class,'index']);
    Route::get('/historia/{id}', [HistoriasController::class,'show']);
    Route::get('/historia/paciente/{id}', [HistoriasController::class,'show_paciente']);
    Route::get('/historia/profesional/{id}', [HistoriasController::class,'show_profesional']);
    Route::post('/historia',[HistoriasController::class,'store']);
    Route::put('/historia/{id}', [HistoriasController::class,'update']);
    Route::patch('/historia/{id}', [HistoriasController::class,'updatePartial']);
    Route::delete('/historia/{id}', [HistoriasController::class,'destroy']);
});

