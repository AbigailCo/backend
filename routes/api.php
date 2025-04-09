<?php

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

Route::middleware('auth:sanctum')->post('/edit-user', [UserController::class, 'editUser']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); // Retorna el usuario autenticado
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

/*Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Las credenciales son incorrectas.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
        'user' => $user,
    ]);
});*/