<?php

namespace App\Http\Controllers;
use App\Models\TypeModel;
use Illuminate\Http\Request;

class TypeController extends Controller
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

        $dataTodelete = TypeModel::where('type', $delete)->first();
        if($dataTodelete){
            $dataTodelete->delete();
            return redirect('/sections')->with([
                'exist' => 'Type'.$request->input('deleteVlaue'),
                'error' => 'sucessfully deleted.',
                'update' => 'Type',
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

            $dataToUpdate = TypeModel::where('type', $currentValue)->first();
            if ($dataToUpdate) {
                $dataToUpdate->type =  htmlspecialchars($updateInput, ENT_QUOTES, 'UTF-8');
                $dataToUpdate->ip_address = htmlspecialchars($this->clientIP );
                $dataToUpdate->save();

                return redirect('/sections')->with([
                    'new' => $request->input('updateInput'),
                    'current' => $request->input('currentValue'),
                    'update' => 'Type',
                ]);
            }
        }catch(\Exception $e){
            return redirect('/sections')->with([
                'exist' => $request->input('updateInput'),
                'update' => 'Type',
            ]);
        }
    }

    public function typeAllData(Request $request){
        $allType = TypeModel::orderBy('created_at', 'desc')->Paginate(10,['*'], 'type-page');
        return view('sections',compact('allType'));
    }

    public function typeMagnet(Request $request){
        //dd($request->all());
        try{
            $request->validate(
                ['type_details'=>['required','string','max:255','unique:type_models,type',],],
                ['type_details.unique' => 'Type already exist.'
            ]);

            TypeModel::create([
                'type'=>$request->input('type_details'),
                'ip_address' => htmlspecialchars($this->clientIP),
            ]);

            return redirect('/sections')->with(['success'=>$request->input('type_details'),
                                            'process'=>'type Material']);
        }catch(\Exception $e){
            return redirect('/sections')->with(['success'=>$request->input('type_details'),
            'process'=>'type already exist']);
        }
    }
}
