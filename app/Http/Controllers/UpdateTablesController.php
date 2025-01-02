<?php

namespace App\Http\Controllers;

use App\Models\AfterMaterialModel;
use App\Models\BeforeMaterialModel;
use App\Models\ProcessModel;
use App\Models\finishModels;
use App\Models\TypeModel;
use Illuminate\Http\Request;

class UpdateTablesController extends Controller
{

    public function allMaterials(Request $request)
    {
        $allAfterMaterial = AfterMaterialModel::orderBy('updated_at', 'desc')->paginate(7, ['*'], 'after-material-page');
        $allBeforeMaterial = BeforeMaterialModel::orderBy('updated_at', 'desc')->paginate(7, ['*'], 'before-material-page');
        $allProcess = ProcessModel::orderBy('updated_at', 'desc')->paginate(7,['*'],'process-page');
        $allFinish = finishModels::orderBy('updated_at', 'desc')->paginate(7,['*'],'process-page');
        $allType = TypeModel::orderBy('created_at', 'desc')->Paginate(10,['*'], 'type-page');
        return view('sections', compact('allAfterMaterial', 'allBeforeMaterial','allProcess','allFinish','allType'));
    }
}

