<?php

use App\Http\Controllers\cambioPrecioController;
use App\Http\Controllers\formaController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\FormPreciosController;
use App\Http\Livewire\RegistrarPrecios;
use App\Livewire\FormCambioPrecioController;
use Illuminate\Support\Facades\Route;
use App\Livewire\FormController;
use App\Livewire\FormPreciosController as LivewireFormPreciosController;
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

    route::get('form-precio', FormPreciosController::class)->name('form.precio');

    route::get('registro-precio' , RegistrarPrecios::class)->name('registro.precio');
    
    Route::middleware('can:crear-usuarios')->group(function () {
        Route::resource('/users', UserController::class);
    });
});

