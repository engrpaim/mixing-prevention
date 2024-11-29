<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddModelController;
use App\Http\Controllers\ProcessListController;
use App\Http\Controllers\BeforeMaterialController;
use App\Http\Controllers\AfterMaterialController;
use App\Http\Controllers\CheckMixingController;
use App\Http\Controllers\finishController;
use App\Http\Controllers\UpdateTablesController;
use App\Models\ProcessModel;
use App\Models\specifications;
use App\Models\AddModel;


//views

Route::view('/mixing-prevention', 'home');
Route::view('/add','add');
Route::view('/check','check');
Route::redirect('/','/mixing-prevention');
Route::view('/flow','flow');
//request routes
Route::get('/add', [AddModelController::class, 'selectOptionProcess']);
Route::get('/check', [CheckMixingController::class, 'ModelDetails']);

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
        return redirect('sections')->with(
            'process_delete',$process);
    });

    Route::get('flow/{id}', function($id){

        $process = ProcessModel::find($id);

        $processFlow = specifications::where('specification',$process["process"])->first();
        $processTitle = $process["process"];
        $processFlows = $processFlow["processes"];
        dump($processTitle);
        dump($processFlow["processes"]);
        //return $process["process"];
        return view('flow',['process'=>$processTitle],['flow'=>$processFlows]);
    });

    Route::post('add', [ProcessListController::class, 'process_add']);
});


Route::get('{type}/{action}/{id}', function($type,$action , $id) {


    //routes for table in section

    $actionRoutes = [
                        'before' => 'App\Models\BeforeMaterialModel',
                        'after' => 'App\Models\AfterMaterialModel',
                        'finish' => 'App\Models\finishModels',
                    ];

    if (array_key_exists($type, $actionRoutes)) {

        $classIdentifier = $actionRoutes[$type];
        $material = $classIdentifier::find($id);

    if ($material) {

        if ($action == "edit") {
            return redirect('sections')->with("{$type}_material_edit", $material);

        } elseif ($action == "delete") {

            return redirect('sections')->with("{$type}_material_delete", $material);
        } else {

            return redirect('sections')->withErrors('Invalid action specified.');
        }
    } else {

        return redirect('sections')->withErrors('Material not found.');
                        }
    } else {
        return redirect('sections')->withErrors('Invalid material type specified.');
    }
});

Route::post('finish-data',[finishController::class,'finishAdd']);
Route::post('model-check-data',[CheckMixingController::class,'FindModel']);
Route::post('add-specs-data',[AddModelController::class,'add']);
Route::post('specs-model-data',[AddModelController::class,'tables']);
Route::post('add-process-data',[ProcessListController::class,'process_add']);
Route::post('before-material-data',[BeforeMaterialController::class,'beforeMaterial']);
Route::post('after-material-data',[AfterMaterialController::class,'afterMaterial']);
Route::post('mixing-check-data', [CheckMixingController::class, 'checkMaterials']);

$updateRoutes = [
    'update-process-data-form' => ProcessListController::class,
    'update-before-data-form' => BeforeMaterialController::class,
    'update-after-data-form' => AfterMaterialController::class,
    'update-finish-data-form' => finishController::class,
];

foreach ($updateRoutes as $name => $controller) {
    Route::post($name, [$controller, 'update'])->name($name);
}


$deleteRoutes = [
    'delete-process-data-form' => ProcessListController::class,
    'delete-before-data-form' => BeforeMaterialController::class,
    'delete-after-data-form' => AfterMaterialController::class,
    'delete-finish-data-form' => finishController::class,
];

foreach ($deleteRoutes as $name => $controller) {
    Route::post($name, [$controller, 'delete'])->name($name);
}





