<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DepartamentoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/modelos', [ModeloController::class, 'index']);
Route::get('/departamentos', [DepartamentoController::class, 'index']);
Route::get('/ciudades/departamento/{id}', [CiudadController::class, 'showByDepartment']);
Route::post('/cotizaciones', [CotizacionController::class, 'store']);
