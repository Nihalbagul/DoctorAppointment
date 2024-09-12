<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('slots', [AppointmentController::class, 'showSlots'])->name('appointments.showSlots');
Route::post('book-appointment', [AppointmentController::class, 'bookAppointment'])->name('appointments.book');
