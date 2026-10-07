<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController as FrontEndHomeController;
use App\Http\Controllers\Backend\HomeController as BackEndHomeController;
use App\Http\Controllers\Backend\SolicitudController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\BackendFuncionario\BackendFuncionarioController;
use App\Http\Controllers\BackendFuncionario\PerfilFuncionarioController;
use App\Http\Controllers\BackendFuncionario\SolicitudFuncionarioController;
use App\Http\Controllers\Backend\PrestamosController;
use App\Models\User;
use PHPUnit\Metadata\Group;
use Yajra\DataTables\Facades\DataTables;

Auth::routes();

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [BackEndHomeController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Solicitudes de Gas
    Route::get('/solicitudes-de-gas', [SolicitudController::class, 'index'])->name('solicitudesDeGas.index');
    Route::get('/solicitudes/buscar', [SolicitudController::class, 'buscar'])->name('solicitudes.buscar');
    Route::get('/solicitudes/historial', [SolicitudController::class, 'historial'])->name('solicitudes.historial');
    Route::post('/adminSolicitud', [SolicitudController::class, 'store'])->name('solicitudAdmin.store');
    Route::get('/create/admin', [SolicitudController::class, 'create'])->name('solicitudAdmin.create');
    Route::post('/create/admin/selected', [SolicitudController::class, 'solicitudGasAdmin'])->name('solicitudAdminsselected.create');
    Route::get('/stock', [SolicitudController::class, 'indexStock'])->name('solicitudesDeGas.stock');

    //prestamos de gas
    Route::get('/prestamos', [PrestamosController::class, 'index'])->name('prestamosDeGas.index');

    //rutas dinámicas
    Route::get('/{id}', [SolicitudController::class, 'show'])->name('solicitudesDeGas.show');
    Route::put('/{id}', [SolicitudController::class, 'update'])->name('solicitudes.update');
    Route::get('/solicitudes/entregado/{id}', [SolicitudController::class, 'entregadoDetalle'])->name('solicitudesDeGas.entregadoDetalle');
});

Route::middleware(['auth', 'role:funcionario'])->prefix('funcionario')->group(function () {
    // inicio
        Route::get('/', [BackendFuncionarioController::class, 'index'])->name('backendFuncionario.index');

    // menú gas bienestar
    Route::group(['prefix' => 'gas-bienestar'], function () {
        Route::get('/', [SolicitudFuncionarioController::class, 'index'])->name('solicitudFuncionario.index');
        Route::get('/create', [SolicitudFuncionarioController::class, 'create'])->name('solicitudFuncionario.create');
        Route::post('/', [SolicitudFuncionarioController::class, 'store'])->name('solicitudFuncionario.store');
        Route::get('/{id}', [SolicitudFuncionarioController::class, 'show'])->name('solicitudFuncionario.show');
        Route::get('/edit/{id}', [SolicitudFuncionarioController::class, 'edit'])->name('solicitudFuncionario.edit');
        Route::put('/{id}', [SolicitudFuncionarioController::class, 'update'])->name('solicitudFuncionario.update');
    });

    // menú perfil
    Route::group(['prefix' => 'perfil'], function () {
        Route::get('/', [PerfilFuncionarioController::class, 'index'])->name('perfilFuncionario.index');
    });

});

Route::get('/', [FrontEndHomeController::class, 'index'])->name('home');

Route::get('/datatables', function () {
    return view('pages.datatables');
});
