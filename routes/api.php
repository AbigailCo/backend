<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



Route::get('/prueba', function () {
    return response()->json(['message' => 'Anda la prueba'], 200);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); // Retorna el usuario autenticado
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