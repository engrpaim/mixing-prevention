<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/add',function(){
    return view('add');
});

Route::get('/check',function(){
    return view('check');
});
