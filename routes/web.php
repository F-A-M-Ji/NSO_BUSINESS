<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::controller(SurveyController::class)->group(function () {
    Route::get('/survey/search', 'search')->name('survey.search');
    Route::post('/survey/check', 'check')->name('survey.check'); // ลิงก์ Check

    Route::get('/survey/form/{id}', 'form')->name('survey.form'); // หน้าถัดไป
    Route::post('/survey/form/save', 'storePart0')->name('survey.storePart0'); 

    Route::get('/survey/part1/{id}', 'part1')->name('survey.part1');
    Route::post('/survey/part1/save', 'storePart1')->name('survey.storePart1');

    Route::get('/survey/part2/{id}', 'part2')->name('survey.part2');
    Route::post('/survey/part2/save', 'storePart2')->name('survey.storePart2');

    Route::get('/survey/part3/{id}', 'part3')->name('survey.part3'); // หน้าแสดงผล
    Route::post('/survey/part3/save', 'storePart3')->name('survey.storePart3'); // บันทึกผล

    Route::get('/survey/part4/{id}', 'part4')->name('survey.part4');
    Route::post('/survey/part4/save', 'storePart4')->name('survey.storePart4');

    Route::get('/survey/part5/{id}', 'part5')->name('survey.part5');
    Route::post('/survey/part5/save', 'storePart5')->name('survey.storePart5');

    Route::get('/survey/part6/{id}', 'part6')->name('survey.part6');
    Route::post('/survey/part6/save', 'storePart6')->name('survey.storePart6');

    Route::get('/survey/part7/{id}', 'part7')->name('survey.part7');
    Route::post('/survey/part7/save', 'storePart7')->name('survey.storePart7');

    Route::get('/survey/thank-you', 'thankYou')->name('survey.thankYou');

    Route::post('/survey/approve/{id}', 'approve')->name('survey.approve');
});