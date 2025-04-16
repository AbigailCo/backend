<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;



Route::get('/prueba', function () {
    return response()->json(['message' => 'Anda la prueba'], 200);
});

Route::middleware('auth:sanctum')->post('/edit-user/{id}', [UserController::class, 'editUser']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'roles' => $user->getRoleNames(),
    ]); 
});

Route::middleware('auth:sanctum')->post('/user/password', function (Request $request) {
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed', Password::defaults()],
    ]);

    $request->user()->update([
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['message' => 'Password updated successfully']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/usuarios', [AdminController::class, 'getUsers']);
    Route::get('/usuario/{id}', [AdminController::class, 'getUser']);
    Route::post('/usuario/{id}/edit', [AdminController::class, 'editUser']);
    Route::post('/usuario/{id}/deshabilitar', [AdminController::class, 'disableUser']);
    Route::post('/usuario/{id}/habilitar', [AdminController::class, 'enableUser']);
});