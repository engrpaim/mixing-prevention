<?php

namespace App\Http\Controllers;

use App\Models\AddModel;
use Illuminate\Http\Request;
use App\Models\ProcessModel;
use App\Models\finishModels;
use App\Models\specifications;
use App\Models\AfterMaterialModel;
use App\Models\BeforeMaterialModel;



class AddModelController extends Controller
{
    protected $Models;
    protected $finishes;
    protected $specs;
    protected $materialAfter;
    protected $materialBefore;

    public function __construct()
    {

        $this->Models = ProcessModel::orderBy('updated_at', 'desc')->get();
        $this->finishes = finishModels::orderBy('updated_at', 'desc')->get();
        $this->specs = specifications::orderBy('updated_at', 'desc')->get();
        $this->materialAfter = AfterMaterialModel::orderBy('updated_at', 'desc')->get();
        $this->materialBefore =BeforeMaterialModel::orderBy('updated_at','desc')->get();
    }

    public function selectOptionProcess() {
        //['allModel' => $this->Models],['allFinish' => $this->finishes],['allMaterial'=>$this->materialAfter],

        $allModel = $this->Models;
        $allFinish = $this->finishes;
        $allMaterial = $this->materialAfter;
        $allBefore = $this->materialBefore;


        return view('add',compact('allModel','allFinish','allMaterial','allBefore') );
    }

    public function tables(Request $request){
        //dd($request->all());
        $processedData = [];
        $processIncluded = [];
        $specifications = $this->specs;

        foreach($specifications as $processes){

            $processIncluded[] = [$processes['specification']=>$processes['processes']];

        }



        $modelName = $request->input("model_name2");
        $finish = $request->input("finish_selected");
        $before = $request->input("before_selected");
        $after = $request->input("after_selected");
        $allModel = $this->Models;
        $allProcess = $request->input('selected_processes2');
        $processArray = explode(';', $allProcess);

        foreach($processArray as $index => $process){
            $data =["process_" . $index =>trim($process)];
            array_push($processedData, $data);
        }



        return redirect('/add')->with (compact('processedData','allModel' , 'modelName','finish','processIncluded','after','before'));
    }

    public function add(Request $request)
    {
        //dd($request->all());
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
            'min_tolerance_thickness' => $request->input('min_tolerance_thickness'),
            */
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
