<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddModelController;
use App\Http\Controllers\ProcessListController;

Route::get('/mixing-prevention', function () {
    return view('home');
});

Route::get('/add',function(){
    return view('add');
});

Route::get('/check',function(){
    return view('check');
});
Route::get('/sections',function(){
    return view('sections');
});
Route::get('/mixing-prevention' ,[AddModelController::class, 'index'])->name('add.model.index');
Route::post('add-model-data',[AddModelController::class,'add']);


Route::get('/mixing-prevention' ,[ProcessListController::class, 'index'])->name('process_add.model.index');
Route::post('add-process-data',[ProcessListController::class,'process_add']);
