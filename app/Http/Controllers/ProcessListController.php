<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessModel;

class ProcessListController extends Controller
{
    public function delete(Request $request)
    {

        $request->validate([
            'deleteVlaue' => 'required|string|max:255',
        ]);

        $delete = $request->input('deleteVlaue');

        $dataTodelete = ProcessModel::where('process', $delete)->first();
        if($dataTodelete){
            $dataTodelete->delete();
            return redirect('/sections')->with([
                'exist' => $request->input('deleteVlaue'),
                'error' => 'sucessfully deleted.',
                'update' => 'Process',
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

            $dataToUpdate = ProcessModel::where('process', $currentValue)->first();
            if ($dataToUpdate) {
                $dataToUpdate->process =  htmlspecialchars($updateInput, ENT_QUOTES, 'UTF-8');
                $dataToUpdate->save();

                return redirect('/sections')->with([
                    'new' => $request->input('updateInput'),
                    'current' => $request->input('currentValue'),
                    'update' => 'Process',
                ]);
            }
        }catch(\Exception $e){
             return redirect('/sections')->with([
                    'exist' => $request->input('updateInput'),
                    'update' => 'Process',
             ]);
        }
    }




    public function process_add(Request $request){

        try {
            $clientIP = request()->ip();

            $request->validate(
                [
                    'add_process' => [
                        'required',
                        'string',
                        'max:255',
                        'unique:process_models,process',
                    ],
                ],
                [
                    'add_process.unique' => 'PROCESS ALREADY EXIST',
                ]
            );

            ProcessModel::create([
                'process' => $request->input('add_process'),
                'ip_address' => $clientIP,
            ]);

            return redirect('/sections')->with([
                'success' => $request->input('add_process'),
                'process' => 'Process',
            ]);
        } catch (\Exception $e) {
            return redirect('/sections')->with([
                'success' => $request->input('add_process'),
                'process' => 'process already exist',]);
        }
    }


}
