<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessModel;
class ProcessListController extends Controller
{


    public function process_add(Request $request){

        try {
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
