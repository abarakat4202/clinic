<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\HomePage;

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

// Main Page Route

Route::get('/', [HomePage::class, 'index'])->middleware(['auth', 'active'])->name('pages-home');


Route::group(['prefix' => 'users/auth'], function () {
    Route::get('login', \App\Modules\User\Controllers\ShowLoginFormController::class)->name('users.auth.login');
    Route::post('login', \App\Modules\User\Controllers\LoginUserController::class);
    Route::any('logout', \App\Modules\User\Controllers\LogoutUserController::class)->middleware('auth')->name('users.auth.logout');
});

Route::group(['prefix' => 'users', 'middleware' => ['auth', 'active']], function () {
    Route::get('/', \App\Modules\User\Controllers\ListUsersController::class)->name('users.index');
    Route::get('/create', \App\Modules\User\Controllers\CreateUserController::class)->name('users.create');
    Route::post('/', \App\Modules\User\Controllers\StoreUserController::class)->name('users.store');
    Route::get('{user}/edit', \App\Modules\User\Controllers\EditUserController::class)->name('users.edit');
    Route::patch('/{user}', \App\Modules\User\Controllers\UpdateUserController::class)->name('users.update');
    Route::delete('/{user}', \App\Modules\User\Controllers\DeleteUserController::class)->name('users.destroy');
});

Route::group(['prefix' => 'roles', 'middleware' => ['auth', 'active']], function () {
    Route::get('/', \App\Modules\Permission\Controllers\ListRolesController::class)->name('roles.index');
    Route::get('/create', \App\Modules\Permission\Controllers\CreateRoleController::class)->name('roles.create');
    Route::post('/', \App\Modules\Permission\Controllers\StoreRoleController::class)->name('roles.store');
    Route::get('{role}/edit', \App\Modules\Permission\Controllers\EditRoleController::class)->name('roles.edit');
    Route::patch('/{role}', \App\Modules\Permission\Controllers\UpdateRoleController::class)->name('roles.update');
    Route::delete('/{role}', \App\Modules\Permission\Controllers\DeleteRoleController::class)->name('roles.destroy');
});

Route::group(['prefix' => 'patients', 'middleware' => ['auth', 'active']], function () {
    Route::get('/', \App\Modules\Patient\Controllers\ListPatientsController::class)->name('patients.index');
    Route::get('/create', \App\Modules\Patient\Controllers\CreatePatientController::class)->name('patients.create');
    Route::post('/', \App\Modules\Patient\Controllers\StorePatientController::class)->name('patients.store');
    Route::get('{patient}/edit', \App\Modules\Patient\Controllers\EditPatientController::class)->name('patients.edit');
    Route::patch('/{patient}', \App\Modules\Patient\Controllers\UpdatePatientController::class)->name('patients.update');
    Route::delete('/{patient}', \App\Modules\Patient\Controllers\DeletePatientController::class)->name('patients.destroy');
    Route::get('/{patient}', \App\Modules\Patient\Controllers\ShowPatientController::class)->name('patients.show');
});

Route::group(['prefix' => 'appointments', 'middleware' => ['auth', 'active']], function () {
    Route::get('/', \App\Modules\Appointment\Controllers\ListAppointmentsController::class)->name('appointments.index');
    Route::get('/create', \App\Modules\Appointment\Controllers\CreateAppointmentController::class)->name('appointments.create');
    Route::post('/', \App\Modules\Appointment\Controllers\StoreAppointmentController::class)->name('appointments.store');
    Route::get('{appointment}/edit', \App\Modules\Appointment\Controllers\EditAppointmentController::class)->name('appointments.edit');
    Route::patch('/{appointment}', \App\Modules\Appointment\Controllers\UpdateAppointmentController::class)->name('appointments.update');
    Route::delete('/{appointment}', \App\Modules\Appointment\Controllers\DeleteAppointmentController::class)->name('appointments.destroy');
    Route::get('/{appointment}', \App\Modules\Appointment\Controllers\ShowAppointmentController::class)->name('appointments.show');
});
