<?php

namespace App\Http\Controllers;
use App\Models\BeforeMaterialModel;
use Illuminate\Http\Request;

class BeforeMaterialController extends Controller
{
    protected $clientIP;

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

        $dataTodelete = BeforeMaterialModel::where('before_material', $delete)->first();
        if($dataTodelete){
            $dataTodelete->delete();
            return redirect('/sections')->with([
                'exist' => 'Material ('.$request->input('deleteVlaue').')',
                'error' => 'sucessfully deleted.',
                'update' => 'Before',
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

            $dataToUpdate = BeforeMaterialModel::where('before_material', $currentValue)->first();
            if ($dataToUpdate) {
                $dataToUpdate->before_material =  htmlspecialchars($updateInput, ENT_QUOTES, 'UTF-8');
                $dataToUpdate->ip_address = htmlspecialchars($this->clientIP );
                $dataToUpdate->save();

                return redirect('/sections')->with([
                    'new' => $request->input('updateInput'),
                    'current' => $request->input('currentValue'),
                    'edited' => 'updated to',
                    'update' => 'Before',
                ]);
            }
        }catch(\Exception $e){
            return redirect('/sections')->with([
                'exist' => $request->input('updateInput'),
                'error' => 'already exist.',
                'update' => 'Before',
            ]);
        }
    }

    public function beforeMaterialAll(){
        $allBeforeMaterial = BeforeMaterialModel::orderBy('created_at','desc')->Paginate(10);
        return view('sections',compact('allBeforeMaterial'));
    }




    public function beforeMaterial(Request $request){
        try{
            $request ->validate(
                ['before_material' => ['required','string','max:255','unique:before_material_models,before_material',],],
                [ 'before_material.unique' => 'Before material already exist.',
            ]);

            BeforeMaterialModel::create([
                'before_material' =>$request->input('before_material'),
                'ip_address' => htmlspecialchars($this->clientIP),
            ]);

            return redirect('/sections')->with(['success'=>$request->input('before_material'),
                                            'process'=>'Before Material']);
        }catch(\Exception $e){
            return redirect('/sections')->with(['success'=>$request->input('before_material'),
            'process'=>'material(before) already exist']);
        }
    }
}
