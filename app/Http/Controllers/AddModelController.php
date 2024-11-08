<?php

namespace App\Http\Controllers;

use App\Models\AddModel;
use Illuminate\Http\Request;
use App\Models\ProcessModel;


class AddModelController extends Controller
{
    protected $Models;

    public function __construct()
    {

        $this->Models = ProcessModel::orderBy('updated_at', 'desc')->get();

    }

    public function selectOptionProcess() {

        return view('add', ['allModel' => $this->Models]);
    }

    public function tables(Request $request){
        //dd($request->all());
        $processedData = [];
        $modelName = $request->input("model_name2");
        $allModel = $this->Models;
        $allProcess = $request->input('selected_processes2');
        $processArray = explode(';', $allProcess);

        foreach($processArray as $index => $process){
            $data =["process_" . $index =>trim($process)];
            array_push($processedData, $data);
        }



        return redirect('/add')->with (compact('processedData','allModel' , 'modelName'));
    }

    public function add(Request $request)
    {
        dD($request->all());
        try{
            $request->validate([
            'model_name2' => 'required|string|max:255|unique:add_models,model_name',
            /*
            'width' => 'required|numeric',
            'max_tolerance_width' => 'required|numeric',
            'min_tolerance_width' => 'required|numeric',
            'length' => 'required|numeric',
            'max_tolerance_length' => 'required|numeric',
            'min_tolerance_length' => 'required|numeric',
            'thickness' => 'required|numeric',
            'max_tolerance_thickness' => 'required|numeric',
            'min_tolerance_thickness' => 'required|numeric',*/],
            [
                'model_name.unique' => 'Model is already added',
            ]);

        AddModel::create([
            'model_name2' => $request->input('model_name2'),
            /*
            'width' => $request->input('width'),
            'max_tolerance_width' => $request->input('max_tolerance_width'),
            'min_tolerance_width' => $request->input('min_tolerance_width'),
            'length' => $request->input('length'),
            'max_tolerance_length' => $request->input('max_tolerance_length'),
            'min_tolerance_length' => $request->input('min_tolerance_length'),
            'thickness' => $request->input('thickness'),
            'max_tolerance_thickness' => $request->input('max_tolerance_thickness'),
            'min_tolerance_thickness' => $request->input('min_tolerance_thickness'),*/
        ]);

        return redirect('/add')->with(['success'=> $request->input('model_name2'),
                                        'process'=>'Model' ,]);
        } catch (\Exception $e) {

            return redirect('/add')->with([
                'success' => $request->input('model_name2'),
                'process' => 'model already exist',]);
        }
    }
}
