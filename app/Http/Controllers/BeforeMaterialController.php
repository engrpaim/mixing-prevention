<?php

namespace App\Http\Controllers;
use App\Models\BeforeMaterialModel;
use Illuminate\Http\Request;

class BeforeMaterialController extends Controller
{


    public function beforeMaterial(Request $request){

        $request ->validate(
            ['before_material' => ['required','string','max:255','unique:before_material_models,before_material',],],
            [ 'before_material.unique' => 'Before material already exist.',
        ]);

        BeforeMaterialModel::create([
            'before_material' =>$request->input('before_material'),
        ]);

        return redirect('/sections')->with(['success'=>$request->input('before_material'),
                                            'process'=>'Before Material']);
    }
}
