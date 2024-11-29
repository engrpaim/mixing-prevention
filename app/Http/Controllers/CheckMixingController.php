<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class CheckMixingController extends Controller
{
    protected $Models;

    public function __construct()
    {
        $this->Models = AddModel::orderBy('updated_at', 'desc')->get();
    }

    public function ModelDetails()
    {
        $modelDetails = $this->Models;
        return view('check',compact('modelDetails'));
    }

    public function checkMaterials(Request $request)
    {
        $readFlow = $request->input('readFlow_cm');
        $selectedModel = htmlspecialchars($request->input('model_cm'));
        $modelDetails = $this->Models;
        $Before = $request->input('before_cm');
        $After  = $request->input('after_cm');
        $Finish = $request->input('finish_cm');
        $OPIFormadetails = $request->input('OPIFormadetails_cm');

        $extractTableToCheck = $request->input('dimensionProcessesArray_cm');
        $dimensionReDisplay['dimensionProcessesArray']= $extractTableToCheck;
        $queryData ='';
        $base ='';
        $min ='';
        $max = '';
        $specsPerTablequery = '';
        $comPareTableSpecs = '';
        $currentColumnChecking = '';
        $frequencyQueryPerData = 0;
        $queryIdentifier = 0;
        $countAndOr = 0;
        $mixingPerDimension = [];
        dump($request->all());

        foreach($extractTableToCheck as $singleKey => $singleValue){

            if($comPareTableSpecs ==''){
                $comPareTableSpecs =  $singleKey;
            }elseif($comPareTableSpecs =  $singleKey){
                $comPareTableSpecs =  $singleKey;
            }
            //count not zeros to limit OR for query
            foreach($singleValue as $isZeroKey => $isZeroValue){
                if($isZeroValue > 0){
                    $queryIdentifier++;//count of values that are > greate than 0
                }
            }
            //dynamically create a query for comparison in SQL data in tables for dimension
            if($comPareTableSpecs != '' && $comPareTableSpecs ==  $singleKey){
                foreach($singleValue as $keyColumn => $valueColumn){
                $countAndOr++; //compare to remove the OR in Compare
                    $frequencyQueryPerData++;
                    $parameterColumn = explode('_',$keyColumn);
                    if($frequencyQueryPerData == 1){
                        $currentColumnChecking = $parameterColumn[0];
                    }
                    //Build query
                    if($currentColumnChecking == $parameterColumn[0] ){
                        switch (true) {
                            case (str_contains($keyColumn,'min')):
                                $min = (float)$valueColumn;
                                if($min != 0){
                                    $queryData = " ".$currentColumnChecking."_val >= ".$min." AND";
                                    $specsPerTablequery .= $queryData;
                                }
                                break;
                            case (str_contains($keyColumn,'max' )):
                                $max = (float)$valueColumn;
                                if($max != 0){
                                    if($queryIdentifier == $countAndOr){
                                        $queryData = " ".$currentColumnChecking."_val <= ".$max."  ";
                                    }else{
                                        $queryData = " ".$currentColumnChecking."_val <= ".$max." OR ";
                                    }
                                    $specsPerTablequery .= $queryData;
                                }
                                break;
                            default:
                                break;
                        }


                    }
                    //reset to initialize _val,_min,_max
                    if($frequencyQueryPerData == 3){
                        $currentColumnChecking ='';
                        $frequencyQueryPerData = 0;
                    }


                }
            }
            // dump($queryIdentifier);
            // dump($countAndOr);


            $compareMixingTableData = DB::table($singleKey)
                                        ->whereRaw($specsPerTablequery)
                                        ->get();
            $mixingPerDimension[$singleKey] = $compareMixingTableData;
            dump($mixingPerDimension);
            // dump($compareMixingTableData);
            // dump('COMBINED:  '.$specsPerTablequery);
            // dump('TABLE: '.$singleKey);
            $queryIdentifier = 0;
            $countAndOr = 0;
            $queryData ='';
            $specsPerTablequery ='';


            //$dimensionTableCheckMixing = DB::table();


        }
        //Already working priority dimension to optimize querying
        //add 'OPIFormadetails' && 'checkedProperties' in compact
        $checkedProperties = DB::table('add_models')
                            ->where(function($query) use ($request) {
                                $query->where('after', 'like', $request->input('after_cm'))
                                      ->orWhere('before', 'like', $request->input('before_cm'))
                                      ->orWhere('finish', 'like', $request->input('finish_cm'));
                            })
                            ->where('model', 'not like',$request->input('model_cm') )
                            ->get();
        //dd($checkedProperties);
        return view('check',compact('checkedProperties','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

    }

    public function FindModel(Request $request)
    {
        dump($request->all());
        $selectedModel = $request->input('model');
        $modelDetails = $this->Models;
        $process = AddModel::where('model', $request->input('model'))->get();
        $modelData = $process->toArray();

        $keyDictionary = ['model','before','after','finish','process_flow'];

        $Before = $modelData[0][$keyDictionary[1]];
        $After  = $modelData[0][$keyDictionary[2]];
        $Finish = $modelData[0][$keyDictionary[3]];
        $readFlow   = $modelData[0][$keyDictionary[4]];
        $process_flow = explode(';',$modelData[0][$keyDictionary[4]]);
        $specificationArray = [];
        for($x = 0; $x < count($process_flow);$x++){
            $remove_special= preg_replace('/[^\w\s]/', '%', $process_flow[$x]);
            $modified_process = str_replace(' ', '%', $remove_special);

            if (Schema::hasTable($modified_process)) {

                $specification = DB::table($modified_process)
                                   ->where('model', $request->input('model'))
                                   ->first();
                                   $specificationArray[$modified_process] = $specification;

            }
        }

        dump($modelDetails);
        return view('check',compact('modelDetails','specificationArray','readFlow','selectedModel','Before','After','Finish'));

    }
}
