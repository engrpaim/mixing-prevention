<?php

namespace App\Http\Controllers;

use App\Models\AddModel;
use Illuminate\Http\Request;
use App\Models\ProcessModel;
use App\Models\finishModels;
use App\Models\specifications;
use App\Models\AfterMaterialModel;
use App\Models\BeforeMaterialModel;
use App\Models\TypeModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AddModelController extends Controller
{
    protected $Models;
    protected $finishes;
    protected $specs;
    protected $materialAfter;
    protected $materialBefore;
    //    $allType = TypeModel::orderBy('created_at', 'desc')->Paginate(10,['*'], 'type-page');
    protected $type;

    public function __construct()
    {

        $this->Models = ProcessModel::orderBy('updated_at', 'desc')->get();
        $this->finishes = finishModels::orderBy('updated_at', 'desc')->get();
        $this->specs = specifications::orderBy('updated_at', 'desc')->get();
        $this->materialAfter = AfterMaterialModel::orderBy('updated_at', 'desc')->get();
        $this->materialBefore =BeforeMaterialModel::orderBy('updated_at','desc')->get();
        $this->type = TypeModel::orderBy('updated_at', 'desc')->get();
    }

    public function selectOptionProcess() {
        //['allModel' => $this->Models],['allFinish' => $this->finishes],['allMaterial'=>$this->materialAfter],

        $allModel = $this->Models;
        $allFinish = $this->finishes;
        $allMaterial = $this->materialAfter;
        $allBefore = $this->materialBefore;
        $allType = $this->type;


        return view('add',compact('allModel','allFinish','allMaterial','allBefore','allType') );
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
        $type = $request->input("type_selected");
        $allModel = $this->Models;
        $allProcess = $request->input('selected_processes2');
        $processArray = explode(';', $allProcess);

        foreach($processArray as $index => $process){
            $data =["process_" . $index =>trim($process)];
            array_push($processedData, $data);
        }



        return redirect('/add')->with (compact('processedData','allModel' , 'modelName','finish','processIncluded','after','before','allProcess','type'));
    }

    public function add(Request $request)
    {

        dump($request->all());

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


            $dataToSaved = [];
            //Dynamic adding off the specs per table
            $dataToSaved = [

                'model' => $request->input('add_model'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'ip_address' => request()->ip()

            ];

            //Static and dynamic validation for adding model and adding specs in table
            $rulesValidation =
            [
                [
                    'add_model' => 'required|string|max:255|unique:add_models,model',
                    'finish_category' => 'required|string|max:255',
                    'after_details' => 'required|string|max:255',
                    'type_details' => 'required|string|max:255',
                    'before_details' => 'required|string|max:255',],

                [
                    'add_model.unique' => 'Model is already added',
                ]
            ];

            $allRequest = $request->all();
            $allSpecs = [];
            $allProcesses = [];
            $uniqueSpecs = [];
            $uniqueProcesses = [];
            //Dynamic data of specifications
            foreach($allRequest as $key => $value){
                if(str_contains($key, '%')){

                    $columnName = explode('+',$key);
                    $process_table =  strtolower($columnName[0]);
                    $specs_dimension = explode("_" , $columnName[1])[0];

                    array_push($allSpecs , $process_table);
                    array_push($allProcesses , $specs_dimension);

                    $uniqueSpecs = array_values(array_unique($allSpecs));
                    $uniqueProcesses = array_values(array_unique($allProcesses));


                }
            }

            foreach($uniqueSpecs as $tableProcess){

                $specsValidation = [];
                $isDataSaved = [];

                foreach($uniqueProcesses as $checkDimension){
                    $isExistDimension = strtoupper($tableProcess)."+".$checkDimension."_val";

                    if(array_key_exists($isExistDimension, $allRequest )){
                        dump($isExistDimension);

                        $saveMinimum = strtoupper($tableProcess)."+".$checkDimension."_min";
                        $saveMaximum = strtoupper($tableProcess)."+".$checkDimension."_max";

                        $isDataSaved[$checkDimension.'_val'] =  $request->input($isExistDimension);
                        $isDataSaved[$checkDimension.'_min'] =  $request->input($saveMinimum);
                        $isDataSaved[$checkDimension.'_max'] =  $request->input($saveMaximum);
                        $specsValidation[$checkDimension.'_val'] = "required|numeric";
                        $specsValidation[$checkDimension.'_min'] = "required|numeric";
                        $specsValidation[$checkDimension.'_max'] = "required|numeric";


                        $isDataSaved= array_merge($dataToSaved,$isDataSaved);
                        // dump($isDataSaved);
                        $rulesValidation[0]  = array_merge($rulesValidation[0], $specsValidation);
                        // dump( $rulesValidation[0] );

                    }



                }

                // dump('check');

                $request->validate($rulesValidation);
                try{
                    DB::table(strtolower($tableProcess))->insert($isDataSaved);
                }catch(\Exception $e){
                    return redirect('/add')->with([
                        'success' => $request->input('add_model'),
                        'process' => 'model already exist',]);
                }



            }

            // dd('stop');
            // dd('hello');

            try{

                AddModel::create([
                    'model' => $request->input('add_model'),
                    'before' => $request->input('before_details'),
                    'after' => $request->input('after_details'),
                    'type' => $request->input('type_details'),
                    'finish' => $request->input('finish_category'),
                    'process_flow' => $request->input('selected_processes3'),
                    'ip_address' => request()->ip()
                ]);

            }catch (\Exception $e) {
                dd($e);
            }


            return redirect('/add')->with([
                                           'success'=> $request->input('add_model'),
                                           'process'=>'Model',
                                          ]);
            } catch (\Exception $e) {
                dd($e);
            }
        }
}
