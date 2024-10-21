<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BagianKelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/auth")->group(function (){
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::group(["middleware" => ["auth:sanctum", "checkrole:admin"], "prefix" => "admin"], function () {
    Route::resource("/user", UserController::class);
    Route::post("user/activate/{id}", [UserController::class,"activate"]);
    Route::post("user/deactivate/{id}", [UserController::class, "deactivate"]);

    Route::resource("/angkatan", AngkatanController::class);
    Route::resource("/jurusan", JurusanController::class);
    Route::apiResource('/bagian-kelas', BagianKelasController::class);

    Route::resource('kelas', KelasController::class);
    Route::get('jurusan/{jurusan}/kelas', [KelasController::class, 'getByJurusan']);
});
