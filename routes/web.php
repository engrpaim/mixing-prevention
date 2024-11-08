<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddModelController;
use App\Http\Controllers\ProcessListController;
use App\Http\Controllers\BeforeMaterialController;
use App\Http\Controllers\AfterMaterialController;
use App\Http\Controllers\UpdateTablesController;
use App\Models\ProcessModel;
use App\Models\BeforeMaterialModel;
use App\Models\AfterMaterialModel;

//views

Route::view('/mixing-prevention', 'home');
Route::view('/add','add');
Route::view('/check','check');
Route::redirect('/','/mixing-prevention');

//request routes
Route::get('/add', [AddModelController::class, 'selectOptionProcess']);
Route::get('/sections',function(){
    return view('sections');
});
Route::get('/sections', [UpdateTablesController::class, 'allMaterials']);

Route::prefix('process')->group(function () {

    Route::get('edit/{id}', function($id){
        $process = ProcessModel::find($id);
        return redirect('sections')->with('process_edit',$process);
    });

    Route::get('delete/{id}', function($id){
        $process = ProcessModel::find($id);
        return redirect('sections')->with('process_delete',$process);
    });

    Route::post('add', [ProcessListController::class, 'process_add']);
});


Route::get('{type}/{action}/{id}', function($type,$action , $id) {
    $modelClass = $type === 'before' ? BeforeMaterialModel::class : AfterMaterialModel::class;
    $material = $modelClass::find($id);

    if($action == "edit")
    {


        return redirect('sections')->with("{$type}_material_edit", $material);

    }
    elseif($action == "delete")
    {
        return redirect('sections')->with("{$type}_material_delete", $material);
    }

});

Route::post('add-specs-data',[AddModelController::class,'add']);
Route::post('specs-model-data',[AddModelController::class,'tables']);
Route::post('add-process-data',[ProcessListController::class,'process_add']);
Route::post('before-material-data',[BeforeMaterialController::class,'beforeMaterial']);
Route::post('after-material-data',[AfterMaterialController::class,'afterMaterial']);

$updateRoutes = [
    'update-process-data-form' => ProcessListController::class,
    'update-before-data-form' => BeforeMaterialController::class,
    'update-after-data-form' => AfterMaterialController::class,
];

foreach ($updateRoutes as $name => $controller) {
    Route::post($name, [$controller, 'update'])->name($name);
}


$deleteRoutes = [
    'delete-process-data-form' => ProcessListController::class,
    'delete-before-data-form' => BeforeMaterialController::class,
    'delete-after-data-form' => AfterMaterialController::class,
];

foreach ($deleteRoutes as $name => $controller) {
    Route::post($name, [$controller, 'delete'])->name($name);
}





