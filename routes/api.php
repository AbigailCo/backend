<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\EstadosGeneralesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UserController;
use App\Models\Servicio;
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
    Route::post('/register-user', [AdminController::class, 'storeUser']);
    

});

//Generales
Route::get('/estados', [EstadosGeneralesController::class, 'getEstados']);
Route::get('/roles', [RolesController::class, 'getRoles']);
Route::get('/categorias', [CategoriasController::class, 'getCategorias']);

//Productos
Route::get('/productos', [ProductosController::class, 'getProductos']);
Route::get('/productos-habi', [ProductosController::class, 'getProductosHabi']);
Route::post('/create-producto', [ProductosController::class, 'storeProducto']);
Route::get('/producto/{id}', [ProductosController::class, 'getProducto']);
Route::post('/producto/{id}/edit', [ProductosController::class, 'editProducto']);
Route::post('/producto/{id}/deshabilitar', [ProductosController::class, 'disableProd']);
Route::post('/producto/{id}/habilitar', [ProductosController::class, 'enableProd']);

//Servicios
Route::get('/servicios', [ServiciosController::class, 'getServicios']);
Route::get('/servicios-habi', [ServiciosController::class, 'getServiciosHabi']);
Route::post('/create-servicio', [ServiciosController::class, 'storeServicio']);
Route::get('/servicio/{id}', [ServiciosController::class, 'getServicio']);
Route::post('/servicio/{id}/edit', [ServiciosController::class, 'editServicio']);
Route::post('/servicio/{id}/deshabilitar', [ServiciosController::class, 'disableServ']);
Route::post('/servicio/{id}/habilitar', [ServiciosController::class, 'enableServ']);

//Proveedores
Route::get('/my-productos/{id}', [ProveedoresController::class, 'myProductos']);
Route::get('/my-servicios/{id}', [ProveedoresController::class, 'myServicios']);
