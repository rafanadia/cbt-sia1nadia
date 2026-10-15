<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/siswa/login', [
    StudentController::class,
    'showLogin',
])->name('siswa.login');

Route::post('/siswa/login', [
    StudentController::class,
    'login',
])->name('siswa.login.submit');

Route::get('/siswa/dashboard', [
    StudentController::class,
    'dashboard',
])->name('siswa.dashboard');

Route::post('/siswa/logout', [
    StudentController::class,
    'logout',
])->name('siswa.logout');

Route::get('/siswa/ujian/{examResult}', [
    StudentController::class,
    'showExam',
])->name('siswa.exam.show');

Route::post('/siswa/ujian/{examResult}/kumpulkan', [
    StudentController::class,
    'submitExam',
])->name('siswa.exam.submit');

Route::get('/siswa/mulai/{subject}', [
    StudentController::class,
    'startExam',
])->name('siswa.exam.start');

Route::get('/siswa/riwayat', [
    StudentController::class,
    'history',
])->name('siswa.hasil');

Route::get('/siswa/riwayat/{examResult}', [
    StudentController::class,
    'showResult',
])->name('siswa.hasil.detail');