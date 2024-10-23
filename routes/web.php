<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddModelController;
use App\Http\Controllers\ProcessListController;
use App\Http\Controllers\BeforeMaterialController;
use App\Http\Controllers\AfterMaterialController;
use App\Http\Controllers\UpdateTablesController;

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


Route::post('add-model-data',[AddModelController::class,'add']);
Route::post('add-process-data',[ProcessListController::class,'process_add']);
Route::post('before-material-data',[BeforeMaterialController::class,'beforeMaterial']);
Route::post('after-material-data',[AfterMaterialController::class,'afterMaterial']);

Route::get('/sections', [UpdateTablesController::class, 'allMaterials']);


