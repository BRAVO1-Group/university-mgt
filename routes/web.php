<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/contact-list', [ContactController::class, 'ContactList'])->name('contact-list');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::get('/forgot-password', [HomeController::class, 'forgotPassword'])->name('forgot-password');
