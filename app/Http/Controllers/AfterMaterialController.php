<?php

namespace App\Http\Controllers;
use App\Models\AfterMaterialModel;
use Illuminate\Http\Request;

class AfterMaterialController extends Controller
{

    public function afterMaterialAllData(Request $request){
        $allAfterMaterial = AfterMaterialModel::orderBy('created_at', 'desc')->Paginate(10,['*'], 'after-material-page');
        return view('sections',compact('allAfterMaterial'));
    }
    public function afterMaterial(Request $request){
        $request->validate(
            ['after_material'=>['required','string','max:255','unique:after_material_models,after_material',],],
            ['after_material.unique' => 'After material already exist.'
        ]);

        AfterMaterialModel::create([
            'after_material'=>$request->input('after_material'),
        ]);

        return redirect('/sections')->with(['success'=>$request->input('after_material'),
                                            'process'=>'After Material']);
    }
}
