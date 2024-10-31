<?php

namespace App\Http\Controllers;
use App\Models\AfterMaterialModel;
use Illuminate\Http\Request;

class AfterMaterialController extends Controller
{
    public function __construct()
    {
        $this->clientIP = request()->ip();
    }
    

    public function delete(Request $request)
    {

        $request->validate([
            'deleteVlaue' => 'required|string|max:255',
        ]);

        $delete = $request->input('deleteVlaue');

        $dataTodelete = AfterMaterialModel::where('after_material', $delete)->first();
        if($dataTodelete){
            $dataTodelete->delete();
            return redirect('/sections')->with([
                'exist' => 'Material ('.$request->input('deleteVlaue').')',
                'error' => 'sucessfully deleted.',
                'update' => 'After',
            ]);
        }


    }

    public function update(Request $request)
    {
        try{




            $request->validate([
                'currentValue' => 'required|string|max:255',
                'updateInput' => 'required|string|max:255',
            ]);

            $currentValue = $request->input('currentValue');
            $updateInput = $request->input('updateInput');

            $dataToUpdate = AfterMaterialModel::where('after_material', $currentValue)->first();
            if ($dataToUpdate) {
                $dataToUpdate->after_material =  htmlspecialchars($updateInput, ENT_QUOTES, 'UTF-8');
                $dataToUpdate->ip_address = htmlspecialchars($this->clientIP );

                $dataToUpdate->save();

                return redirect('/sections')->with([
                    'new' => $request->input('updateInput'),
                    'current' => $request->input('currentValue'),
                    'update' => 'After',
                ]);
            }
        }catch(\Exception $e){
            return redirect('/sections')->with([
                'exist' => $request->input('updateInput'),
                'update' => 'After',
            ]);
        }
    }

    public function afterMaterialAllData(Request $request){
        $allAfterMaterial = AfterMaterialModel::orderBy('created_at', 'desc')->Paginate(10,['*'], 'after-material-page');
        return view('sections',compact('allAfterMaterial'));
    }
    public function afterMaterial(Request $request){
        try{
            $request->validate(
                ['after_material'=>['required','string','max:255','unique:after_material_models,after_material',],],
                ['after_material.unique' => 'After material already exist.'
            ]);

            AfterMaterialModel::create([
                'after_material'=>$request->input('after_material'),
                'ip_address' => htmlspecialchars($this->clientIP),
            ]);

            return redirect('/sections')->with(['success'=>$request->input('after_material'),
                                            'process'=>'After Material']);
        }catch(\Exception $e){
            return redirect('/sections')->with(['success'=>$request->input('after_material'),
            'process'=>'after(material) already exist']);
        }
    }
}
