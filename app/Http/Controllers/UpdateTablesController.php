<?php

namespace App\Http\Controllers;

use App\Models\AfterMaterialModel;
use App\Models\BeforeMaterialModel;
use App\Models\ProcessModel;
use Illuminate\Http\Request;

class UpdateTablesController extends Controller
{

    public function allMaterials(Request $request)
    {
        $allAfterMaterial = AfterMaterialModel::orderBy('created_at', 'desc')->paginate(7, ['*'], 'after-material-page');
        $allBeforeMaterial = BeforeMaterialModel::orderBy('created_at', 'desc')->paginate(7, ['*'], 'before-material-page');
        $allProcess = ProcessModel::orderBy('created_at', 'desc')->paginate(7,['*'],'process-page');
        return view('sections', compact('allAfterMaterial', 'allBeforeMaterial','allProcess'));
    }
}

