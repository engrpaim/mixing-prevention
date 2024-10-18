<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddModelController;

Route::get('/mixing-prevention', function () {
    return view('home');
});

Route::get('/add',function(){
    return view('add');
});

Route::get('/check',function(){
    return view('check');
});

Route::get('/mixing-prevention' ,[AddModelController::class, 'index'])->name('add.model.index');
Route::post('add-model-data',[AddModelController::class,'add']);
