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
        dd($request->all());
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
        //dump($request->all());

        $valuePerData = [
            'length_val' => 'L',
            'length_min' => '-',
            'length_max' => '+',
            'width_val' => 'W',
            'width_min' => '-',
            'width_max' => '+',
            'thickness_val' => 'T',
            'thickness_min' => '-',
            'thickness_max' => '+',
            'ir_val' => 'OR',
            'ir_min' => '-',
            'ir_max' => '+',
            'or_val' => 'IR',
            'or_min' => '-',
            'or_max' => '+',
            'a_val' => 'A',
            'a_min' => '-',
            'a_max' => '+',
        ];

        $notCurrentModel = " AND model NOT LIKE '".$selectedModel."' ";
        if(isset($extractTableToCheck) && !empty($extractTableToCheck)){
            foreach($extractTableToCheck as $singleKey => $singleValue){

                if($comPareTableSpecs ==''){
                    $comPareTableSpecs =  $singleKey;
                }elseif($comPareTableSpecs =  $singleKey){
                    $comPareTableSpecs =  $singleKey;
                }
                //count not zeros to limit OR for query
                foreach($singleValue as $isZeroKey => $isZeroValue){
                    if($isZeroValue != 0){
                        $queryIdentifier++;//count of values that are > greate than 0
                    }
                }
                // dump($queryIdentifier);
                // dump($singleValue);
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
                                        //dump($queryIdentifier."----".$countAndOr);
                                        if($queryIdentifier == $countAndOr){
                                            $queryData = " ".$currentColumnChecking."_val <= ".$max."  $notCurrentModel";
                                        }else{
                                            $queryData = " ".$currentColumnChecking."_val <= ".$max."  $notCurrentModel OR ";
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


                try{
                    $compareMixingTableData = DB::table($singleKey)
                                            ->whereRaw($specsPerTablequery)
                                            ->get();
                    $mixingPerDimension[$singleKey] = $compareMixingTableData;
                }catch(\Exception $e){
                    dump($e);
                    continue;
                }



                // dump($compareMixingTableData);
                // dump('COMBINED:  '.$specsPerTablequery);
                // dump('TABLE: '.$singleKey);
                $queryIdentifier = 0;
                $countAndOr = 0;
                $queryData ='';
                $specsPerTablequery ='';


                //$dimensionTableCheckMixing = DB::table();


            }

        }

        //dump($mixingPerDimension);
        //dd($countAndOr);
        $identifierTableDimensionMixing = explode(";",$readFlow);
        // dump($identifierTableDimensionMixing);
        // dump($mixingPerDimension);
        $base = '';
        $max  = '';
        $minNotSame = '';
        $currentDimensionProcess = '';
        $isColumnHaveValue = 0;
        $isCombinedSpecs = '';
        $isModelMixing = '';
        $isTotalCount = 0;
        $isArrayResultPerModelMixing =[];
        $columnIdenTifier = 0;
        foreach($mixingPerDimension as $keMixingKey ){

            //dump($keMixingKey);
            foreach($keMixingKey as $invKey => $invValue){

                if( $isTotalCount == 0){
                    foreach($invValue as $counterKey => $counterValue){

                        if(array_key_exists($counterKey,$valuePerData) && $counterValue  != 0 && $counterValue  != 0.0){
                            //dump($counterKey );
                            $isTotalCount++;
                        }
                    }
                   // dump($isTotalCount);
                }

                foreach($invValue as $dataKey => $dataValue){

                    if(str_contains($dataKey,"model") &&  $isModelMixing == ''){
                        $isModelMixing = $dataValue;
                    }elseif(str_contains($dataKey,"model") && $isModelMixing != $dataValue){
                        $isModelMixing = $dataValue;
                        //dump( $dataValue);

                    }

                    if($dataValue != 0){
                        if(array_key_exists($dataKey,$valuePerData)){
                            switch($dataKey){

                                case(str_contains($dataKey,"_val")):
                                    //dump($dataKey ." ---- ". $dataValue);
                                    $base =  $dataValue.$valuePerData[$dataKey];
                                    $currentDimensionProcess = $base;
                                    break;
                                case(str_contains($dataKey,"_min")):
                                    $min  =  $dataValue;
                                    $minNotSame = $valuePerData[$dataKey].$min;
                                    break;
                                case(str_contains($dataKey,"_max")):
                                    $isColumnHaveValue++;
                                    $max =  $dataValue;
                                    if( $min == $max){
                                        $currentDimensionProcess .= "±" .$max;
                                    }else{
                                        $currentDimensionProcess .= "±" .$max."/".$minNotSame;
                                        $minNotSame= '';
                                    }
                                    //dump($isColumnHaveValue);
                                    if($isCombinedSpecs == ''){
                                        $isCombinedSpecs = $currentDimensionProcess;
                                    }elseif( $isColumnHaveValue <= 3){
                                        $isCombinedSpecs .= " x ".$currentDimensionProcess;
                                        if($isColumnHaveValue == 3){
                                            // dump($isCombinedSpecs );
                                            // dump( $isModelMixing);
                                            // dump('Identifier:'.$columnIdenTifier);
                                            // dump();
                                            $isArrayResultPerModelMixing[$isModelMixing][$columnIdenTifier."_dimension_process"] = $isCombinedSpecs;
                                            $isColumnHaveValue = 0;
                                            $isCombinedSpecs = '';

                                        }
                                    }
                                    break;
                            }
                        }


                    }


                }

            }
            $columnIdenTifier++;
        }

        //dd('hello');
        //Already working priority dimension to optimize querying
        //add 'OPIFormadetails' && 'checkedProperties' in compact
        //SET THE MODEL TO BE DISPLAYED
        $setModelMixing='';
        foreach($isArrayResultPerModelMixing as $materialsMixingKey => $materialsMixingValue ){

            try{
                $checkedProperties = DB::table('add_models')
                    ->where('model', 'LIKE',$materialsMixingKey )
                    ->get();

                if ($checkedProperties->isEmpty()) {

                    continue;
                }
                $neededDataArraytoSetModel = ['model','before','after','finish'];
                foreach($checkedProperties as $keySet => $keyValue){
                    // dump($keyValue);
                    foreach( $keyValue as $getActualKey => $getActualValue){
                        if(in_array($getActualKey,$neededDataArraytoSetModel)){
                            if(in_array($getActualKey,$neededDataArraytoSetModel) && $getActualKey != "model" && $setModelMixing != ''){
                                $isArrayResultPerModelMixing[$setModelMixing][$getActualKey] = $getActualValue;
                            }else{
                                $setModelMixing = $getActualValue;
                            }
                        }
                    }

                }

            }catch(\Exception $e){
                dump( $e);
            }



        }

        //dump($isArrayResultPerModelMixing);
       // dd('hello');
       if(isset($checkedProperties) && !empty($checkedProperties)){
            return view('check',compact('isArrayResultPerModelMixing','checkedProperties','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));
       }else{
            return view('check',compact('isArrayResultPerModelMixing','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

       }

    }

    public function FindModel(Request $request)
    {
        //dump($request->all());
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
        $valuePerData = [
            'length_val' ,
            'length_min' ,
            'length_max' ,
            'width_val' ,
            'width_min' ,
            'width_max' ,
            'thickness_val' ,
            'thickness_min' ,
            'thickness_max' ,
            'ir_val' ,
            'ir_min' ,
            'ir_max' ,
            'or_val' ,
            'or_min' ,
            'or_max',
            'a_val' ,
            'a_min',
            'a_max' ,
        ];

        $baseValue = 0;
        $minValue = 0;
        $maxValue = 0;
        $computedArray = [];
        for($x = 0; $x < count($process_flow);$x++){
            //convert name table naming replace all special character with '%'
            $remove_special= preg_replace('/[^\w\s]/', '%', $process_flow[$x]);
            $modified_process = str_replace(' ', '%', $remove_special);

            if (Schema::hasTable($modified_process)) {
                //Get specifications per table
                $specification = DB::table($modified_process)
                                   ->where('model', $request->input('model'))
                                   ->first();
                                   $specificationArray[$modified_process] = $specification;
                $currentSpecCompute ='';
                $specGroupValues= '';


                //Compute min/max value based on specification per table
                foreach($specification as $computeKey => $computeVal){

                    $currentSpecCompute = explode("_",$computeKey);



                    if(in_array($computeKey,$valuePerData)){

                            if($specGroupValues == ''){
                                $specGroupValues = $currentSpecCompute[0];

                            }

                            if($specGroupValues === $currentSpecCompute[0]){
                                switch($computeKey){
                                    case(str_contains($computeKey,"_val")):
                                        $baseValue = $computeVal;
                                        break;
                                    case(str_contains($computeKey,"_min")):
                                        $minValue = $computeVal;
                                        break;
                                    case(str_contains($computeKey,"_max")):

                                        $maxValue = $computeVal;

                                        $computedValueMax = $baseValue + floatval($maxValue);
                                        $computedValueMin = $baseValue - floatval($minValue);
                                        $computedArray[$modified_process][$specGroupValues."_computed_max"] = $computedValueMax;
                                        $computedArray[$modified_process][$specGroupValues."_computed_min"] = $computedValueMin;


                                        break;

                                    default:
                                        break;
                                }
                            }else{

                                $specGroupValues = $currentSpecCompute[0];

                                switch($computeKey){
                                    case(str_contains($computeKey,"_val")):
                                        $baseValue = $computeVal;
                                        break;
                                    case(str_contains($computeKey,"_min")):
                                        $minValue = $computeVal;
                                        break;
                                    case(str_contains($computeKey,"_max")):
                                        $maxValue = $computeVal;

                                        $computedValueMax = $baseValue + floatval($maxValue);
                                        $computedValueMin = $baseValue - floatval($minValue);
                                        $computedArray[$modified_process][$specGroupValues."_computed_max"] = $computedValueMax;
                                        $computedArray[$modified_process][$specGroupValues."_computed_min"] = $computedValueMin;

                                        break;
                                    default:
                                        break;
                                    }
                            }

                    }

                }
            }
        }

        return view('check',compact('computedArray','modelDetails','specificationArray','readFlow','selectedModel','Before','After','Finish'));

    }
}
