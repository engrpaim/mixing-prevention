<?php

namespace App\Http\Controllers;

use App\Models\AddModel;
use Illuminate\Http\Request;
use App\Models\ProcessModel;
use App\Models\finishModels;
use App\Models\specifications;
use App\Models\AfterMaterialModel;
use App\Models\BeforeMaterialModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        //dd($processIncluded );

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



        return redirect('/add')->with (compact('processedData','allModel' , 'modelName','finish','processIncluded','after','before','allProcess'));
    }

    public function add(Request $request)
    {

     //dd($request->all());

        try{
            $totalProcessChecker = [];
            $totalNumberPerSpecs = [];
            $perProcessCounter = 0;
            $specsCompareCount = '';
            $countDimensionProcesses = 0;
            $processesDimension = explode(";",$request->input('selected_processes3'));
            $maxDimension = count($processesDimension) - 1;
            $currentTable  = '';
            $processCurrentCount  = 0;

            $specsValidation = [];
            $dataToSaved = [];
            //Dynamic adding off the specs per table
            $dataToSaved = [

                'model' => $request->input('add_model'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];

            //Static and dynamic validation for adding model and adding specs in table
            $rulesValidation =
            [
                [
                    'add_model' => 'required|string|max:255|unique:add_models,model',
                    'finish_category' => 'required|string|max:255',
                    'after_details' => 'required|string|max:255',
                    'before_details' => 'required|string|max:255',],
                [
                    'add_model.unique' => 'Model is already added',
                ]
            ];

            $allRequest = $request->all();
            //count the number of specs min max
            foreach($allRequest as $key => $value){
                $tableSpecs = explode('+',$key);
                if(str_contains($tableSpecs[0], '%')){

                    if($specsCompareCount == '' ){
                        $perProcessCounter += 1;
                        $specsCompareCount = $tableSpecs[0];
                    }elseif($specsCompareCount != $tableSpecs[0]){
                        array_push($totalProcessChecker,$tableSpecs[0]);
                        $totalNumberPerSpecs [$tableSpecs[0]] = $perProcessCounter;
                        dump( $totalNumberPerSpecs);
                        $perProcessCounter = 1;
                        $specsCompareCount = $tableSpecs[0];
                    }else{
                        $perProcessCounter += 1;
                    }
                }


            }

            //Dynamic data of specifications
            foreach($allRequest as $key => $value){
                if(str_contains($key, '%')){

                    $columnName = explode('+',$key);


                  if($currentTable != $columnName[0] && $currentTable != ''){
                        //if new process save to unmigrated database
                        dump($totalNumberPerSpecs[$columnName[0]]);
                        $countDimensionProcesses += 1;
                        $rulesValidation[0] = array_merge($rulesValidation[0],$specsValidation);
                        $request->validate($rulesValidation);

                        try{
                           DB::table($currentTable)->insert($dataToSaved);
                           $dataToSaved= [];
                           $dataToSaved = [

                            'model' => $request->input('add_model'),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),

                            ];
                            $specsValidation[$key] = "required|numeric";
                            $dataToSaved [$columnName[1]] = $request->input($key);
                        }catch(\Exception $e){
                            dd($e);
                        }
                        $currentTable = $columnName[0];
                        dump('New table: '.$currentTable);

                    }else{

                        if( $currentTable == ''){
                            dump("max: ".$maxDimension);
                            $countDimensionProcesses += 1;
                            $currentTable = $columnName[0];
                        }
                        $processCurrentCount += 1;
                        $specsValidation[$key] = "required|numeric";
                        $dataToSaved [$columnName[1]] = $request->input($key);
                        echo $key."----->".$columnName[1]."---value--->".$value."<br/>";

                    }
                }
            }
            //Add the last process
            if($maxDimension == $countDimensionProcesses){
                dump('Process count dimension: '. $countDimensionProcesses);
                dump('max: ' . $maxDimension);
                dump($dataToSaved);
                dump($perProcessCounter , $processCurrentCount);

                $rulesValidation[0] = array_merge($rulesValidation[0],$specsValidation);
                $request->validate($rulesValidation);

                try{
                   DB::table($currentTable)->insert($dataToSaved);
                }catch(\Exception $e){
                    dd($e);
                }
                $currentTable = $columnName[0];
                dump('New table: '.$currentTable);
            }
          // dd('stop');




            AddModel::create([
                'model' => $request->input('add_model'),
                'before' => $request->input('before_details'),
                'after' => $request->input('after_details'),
                'finish' => $request->input('finish_category'),
                'process_flow' => $request->input('selected_processes3'),
            ]);


            return redirect('/add')->with(['success'=> $request->input('add_model'),
                                        'process'=>'Model' ,]);
            } catch (\Exception $e) {
                dd($e);
                return redirect('/add')->with([
                    'success' => $request->input('model_name2'),
                    'process' => 'model already exist',]);
            }
        }
}
