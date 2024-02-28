<?php

use App\Http\Controllers\cambioPrecioController;
use App\Http\Controllers\formaController;
use App\Http\Controllers\UserController;
use App\Livewire\FormCambioPrecioController;
use Illuminate\Support\Facades\Route;
use App\Livewire\FormController;
use App\Livewire\FormPruebaController;
use App\Livewire\FormSiniestrosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/form', FormSiniestrosController::class)->name('form');
    Route::post('/submit', [formaController::class, 'submitForm'])->name('submit.form');

    Route::get('/form-cambio-precio', [CambioPrecioController::class, 'index'])->name('form-cambio-precio');
    Route::get('/productos/{listaPrecioId}', [CambioPrecioController::class, 'getProductos'])->name('productos');
    Route::post('/update-precios', [CambioPrecioController::class, 'updatePrecios'])->name('update.precios');
    Route::get('/restore-precio', [CambioPrecioController::class, 'restorePrice'])->name('restore.price');
    Route::get('/obtener-precio-local/{idProducto}', [CambioPrecioController::class, 'obtenerPrecioLocal'])->name('obtener.precio.local');

    route::get('form-precio', FormCambioPrecioController::class)->name('form.precio');;
    Route::middleware('can:crear-usuarios')->group(function () {
        Route::resource('/users', UserController::class);
    });
});

