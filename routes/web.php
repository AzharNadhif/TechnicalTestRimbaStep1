<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('login');
});

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/admin', function () {
    return view('admin');
});

