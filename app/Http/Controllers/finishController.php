<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\finishModels;

class finishController extends Controller
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

        $dataTodelete = finishModels::where('finish', $delete)->first();
        if($dataTodelete){
            $dataTodelete->delete();
            return redirect('/sections')->with([
                'exist' => $request->input('deleteVlaue'),
                'error' => 'sucessfully deleted.',
                'update' => 'Finish',
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

            $dataToUpdate = finishModels::where('finish', $currentValue)->first();
            if ($dataToUpdate) {
                $dataToUpdate->finish =  htmlspecialchars($updateInput, ENT_QUOTES, 'UTF-8');
                $dataToUpdate->ip_address = htmlspecialchars($this->clientIP );
                $dataToUpdate->save();

                return redirect('/sections')->with([
                    'new' => 'updated to '.$request->input('updateInput'),
                    'current' => $request->input('currentValue'),
                    'update' => 'Finish',
                ]);
            }
        }catch(\Exception $e){
             return redirect('/sections')->with([
                    'exist' => $request->input('updateInput'),
                    'update' => 'Finish',
             ]);
        }
    }

    public function finishAdd(Request $request){

        try {

            $request->validate(
                [
                    'finish_details' => [
                        'required',
                        'string',
                        'max:255',
                        'unique:finish_models,finish',
                    ],
                ],
                [
                    'finish_details.unique' => 'FINISH ALREADY EXIST',
                ]
            );

            finishModels::create([
                'finish' => $request->input('finish_details'),
                'ip_address' => htmlspecialchars($this->clientIP),
            ]);
            //dd($clientIP);
            return redirect('/sections')->with([
                'success' => $request->input('finish_details'),
                'process' => 'Finish',
            ]);
        } catch (\Exception $e) {
            return redirect('/sections')->with([
                'success' =>  $request->input('finish_details'),
                'process' => 'finish already exist',]);
        }
    }
}
