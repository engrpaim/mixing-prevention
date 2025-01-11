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
        $isArrayResultPerModelMixing=[];
        $neededDataArraytoSetModel = ['model','before','after','finish','type'];
        $identifiedParameters = ['length','width','thickness','radius'];
        $computedArray = $request->input('computedArray_cm');
        foreach($request->all() as $passedDataKey => $passedDataValue ){
            if(str_contains($passedDataKey,"_range")){
                $displayRangeValues[$passedDataKey] = $passedDataValue;
            }
        }
        //dump(  $request->all());
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
        ////dump($request->all());

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
        $isEqualQuery = '';
        $processCount = 0;
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
                            $valueWhere = explode("_",$keyColumn);

                            switch (true) {
                                case (str_contains($keyColumn,'min')):
                                    $min = (float)$valueColumn;

                                    $rangeMin = (float)$request->input($parameterColumn[0]."_range");
                                    $computeMinRange =  $min - $rangeMin;

                                    if($min != 0){
                                        $queryData = " (".$currentColumnChecking."_val >= ".$computeMinRange." AND";
                                        $specsPerTablequery .= $queryData;
                                        if($isEqualQuery == ''){
                                            $isEqualQuery = "CASE WHEN ".$parameterColumn[0]."_val BETWEEN ".$computeMinRange." ";
                                        }else{
                                            $isEqualQuery .= "CASE WHEN ".$parameterColumn[0]."_val BETWEEN ".$computeMinRange." ";
                                        }


                                    }



                                    break;
                                case (str_contains($keyColumn,'max' )):
                                    $max = (float)$valueColumn;
                                    $rangeMax = (float)$request->input($parameterColumn[0]."_range");
                                    $computeMaxRange =  $max + $rangeMax;

                                    if($max != 0){

                                        if($queryIdentifier == $countAndOr){

                                            $queryData = " ".$currentColumnChecking."_val <= ".$computeMaxRange."  $notCurrentModel)";
                                            $isEqualQuery .="AND ".$computeMaxRange." THEN 1 ELSE 0 END AS ".$parameterColumn[0]." ";

                                        }else{

                                            $queryData = " ".$currentColumnChecking."_val <= ".$computeMaxRange."  $notCurrentModel ) OR ";
                                            $isEqualQuery .="AND ".$computeMaxRange." THEN 1 ELSE 0 END AS ".$parameterColumn[0].",";

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

                    $isEqualAllDimension = DB::table(strtolower($singleKey))
                                            ->selectRaw('model, '.$isEqualQuery)
                                            ->whereNotLike('model', $selectedModel)
                                            ->havingRaw('length = 1 AND width = 1 AND thickness = 1')
                                            ->get();



                    foreach($isEqualAllDimension as $allKey){
                      $isSameAllDimension[$allKey->model][$processCount."_allsame"] = $processCount;
                    }

                }catch(\Exception $e){
                    dump($e);
                    continue;
                }


                try{


                    $compareMixingTableData = DB::table(strtolower($singleKey))
                                            ->whereRaw($specsPerTablequery)
                                            ->get();
                    $mixingPerDimension[$singleKey] = $compareMixingTableData;
                    //COMPUTATION FOR THE MODAL OF JUDGEMENT PER RULE BETWEEN 0 TO 1 DIFFERENCE
                    $ruleModel ='';
                    $rulesIdentifier = 0;
                    $currentCounter = 0;
                    foreach($compareMixingTableData as $ruleDatalist){

                        foreach($ruleDatalist as $ruleKey  => $ruleValue){
                            switch($ruleKey ){
                                case(str_contains($ruleKey,"_val" )):
                                    if($ruleValue > 0){

                                        $specsDimensionSide  = explode("_",$ruleKey)[0];

                                        if(in_array($specsDimensionSide,$identifiedParameters)){
                                            $ruleChecker = $extractTableToCheck[$singleKey][$specsDimensionSide."_base"] - $ruleValue;
                                            $isArrayResultPerModelMixing [$ruleModel][$processCount."_".$specsDimensionSide."_compareTarget"]= $extractTableToCheck[$singleKey][$specsDimensionSide."_base"]." - ". $ruleValue." = |".$ruleChecker."|";
                                            $isNeedToHighlighted[$ruleModel][$processCount."_".$specsDimensionSide] = $ruleChecker;
                                            //dump($singleKey."->".$specsDimensionSide."->".$extractTableToCheck[$singleKey][$specsDimensionSide."_base"]." - ". $ruleValue." = ".  $ruleChecker );
                                        }

                                    }
                                    break;

                                case($ruleKey == "model" ):
                                    $ruleModel = $ruleValue;
                                    //dump($ruleValue);
                                    break;

                            }
                        }


                    }




                }catch(\Exception $e){
                    dump($e);

                    continue;
                }

                $queryIdentifier = 0;
                $countAndOr = 0;
                $queryData ='';
                $specsPerTablequery ='';
                $isEqualQuery='';


                $processCount++;
            }

        }

        $identifierTableDimensionMixing = explode(";",$readFlow);
        $base = '';
        $max  = '';
        $minNotSame = '';
        $currentDimensionProcess = '';
        $isColumnHaveValue = 0;
        $isCombinedSpecs = '';
        $isModelMixing = '';
        $isTotalCount = 0;

        $columnIdenTifier = 0;
        $debugCount= 0;
        foreach($mixingPerDimension as $keMixingKey ){

            foreach($keMixingKey as $invKey => $invValue){

                if( $isTotalCount == 0){
                    foreach($invValue as $counterKey => $counterValue){

                        if(array_key_exists($counterKey,$valuePerData) && $counterValue  != 0 && $counterValue  != 0.0){

                            $isTotalCount++;
                        }
                    }

                }

                foreach($invValue as $dataKey => $dataValue){

                    if(str_contains($dataKey,"model") &&  $isModelMixing == ''){
                        $isModelMixing = $dataValue;
                    }elseif(str_contains($dataKey,"model") && $isModelMixing != $dataValue){
                        $isModelMixing = $dataValue;


                    }

                    if($dataValue != 0  ){
                        if(array_key_exists($dataKey,$valuePerData)){
                            switch($dataKey){

                                case(str_contains($dataKey,"_val")):

                                    $base =  $dataValue.$valuePerData[$dataKey];
                                    $currentDimensionProcess = $base;
                                    break;
                                case(str_contains($dataKey,"_min")):


                                    if($dataValue != 0){

                                        $min  =  $dataValue;
                                        $minNotSame = $valuePerData[$dataKey].$min;

                                    }


                                    break;
                                case(str_contains($dataKey,"_max")):

                                    $isColumnHaveValue++;
                                    $max =  $dataValue;


                                    if($isCombinedSpecs == ''){

                                        if( $min == $max){
                                            $isCombinedSpecs = $currentDimensionProcess." ± ".$max." x ";
                                        }else{
                                            $isCombinedSpecs = $currentDimensionProcess." ± ".$max."/".$minNotSame." x ";
                                        }

                                    }elseif( $isColumnHaveValue <= 3){

                                        if( $min == $max && $isColumnHaveValue != 3){
                                            $isCombinedSpecs .= $currentDimensionProcess ." ± ".$max ." x ";
                                        }elseif($min != $max && $isColumnHaveValue != 3){
                                            $isCombinedSpecs .= $currentDimensionProcess."± ".$max."/".$minNotSame." x ";
                                        }

                                        if($isColumnHaveValue == 3){

                                            if( $min == $max){
                                                $isCombinedSpecs .= $currentDimensionProcess ." ± ".$max;
                                            }else{
                                                $isCombinedSpecs .= $currentDimensionProcess."± ".$max."/".$minNotSame;
                                            }


                                            $isArrayResultPerModelMixing[$isModelMixing][$columnIdenTifier."_dimension_process"] = $isCombinedSpecs;

                                            $isColumnHaveValue = 0;
                                            $isCombinedSpecs = '';
                                            $max = 0;
                                            $min = 0;

                                        }
                                    }
                                    break;
                            }
                        }


                    }

                    if($debugCount == 2){

                    }
                }
                $debugCount++;
            }
            $columnIdenTifier++;
        }


        //SET THE MODEL TO BE DISPLAYED
        $setModelMixing='';
        if(!empty($isArrayResultPerModelMixing)){
            foreach($isArrayResultPerModelMixing as $materialsMixingKey => $materialsMixingValue ){

                try{
                    $checkedProperties = DB::table('add_models')
                        ->where('model', 'LIKE',$materialsMixingKey )
                        ->get();
                    dump($checkedProperties);
                    if ($checkedProperties->isEmpty()) {

                        continue;
                    }

                    foreach($checkedProperties as $keySet => $keyValue){

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
        //RULE COLOR IDENTIFIER
        $HiglightedArray = [];
        $RmHiglightedArray = [];
        $countTheSame = 0;
        $countSameHighlighted = 0;
        $ruleBool = false;
        $counterTrue = 0;
        $colorIndicator = [];
        $countTruePerProcess = [];
        $RMTruePerProcess = [];

        foreach($isNeedToHighlighted as $isDataHighlightedKey => $isDataHighlightedValue){


            foreach($isDataHighlightedValue as $isDataToSetKey => $isDataToSetValue  ){

                //RAW MATERIAL COLOR IDENTIFIER
                if(isset($identifierTableDimensionMixing[$counterTrue])  && $identifierTableDimensionMixing[$counterTrue] == "RAW MATERIAL"){

                    if(count($RmHiglightedArray) <= 1){

                        array_push( $RmHiglightedArray,abs($isDataToSetValue));
                    }elseif(count($RmHiglightedArray) == 2){

                        array_push( $RmHiglightedArray,abs($isDataToSetValue));
                        $currentLocationProcess = explode("_",$isDataToSetKey )[0];

                        $resultRm = array_filter($RmHiglightedArray, function($value) {
                            if(abs($value) >= 0 &&  abs($value) < 1.99){
                                return true;
                            }
                        });
                        if( count($resultRm) == 3){
                            $RMTruePerProcess[$isDataHighlightedKey][$currentLocationProcess]= count($resultRm);
                        }

                        $RmHiglightedArray=[];

                    }
                }
                //if other process dimension
                if(count($HiglightedArray) <= 1){
                    array_push( $HiglightedArray,$isDataToSetValue);
                }elseif(count($HiglightedArray) == 2){
                    array_push( $HiglightedArray,$isDataToSetValue);

                    $result = array_filter($HiglightedArray, function($value) {
                        if(abs($value) >= 0 &&  abs($value) < 1.99){

                            return true;
                        }
                    });

                    $currentLocationProcess = explode("_",$isDataToSetKey )[0];
                    //IGNORE BELOW ONE BASE ON RULE ONLY 2  AND 3 HAVE COLOR
                    if( count($result) > 1){
                        $countTruePerProcess[$isDataHighlightedKey][$currentLocationProcess]= count($result);
                    }



                    $counterTrue++;
                    $HiglightedArray=[];
                }

            }

            $counterTrue = 0;

        }

    }


       if(isset($checkedProperties) && !empty($checkedProperties)){
            if(!empty($isSameAllDimension) && empty($countTruePerProcess) ){
                return view('check',compact('isSameAllDimension','displayRangeValues','computedArray','isArrayResultPerModelMixing','checkedProperties','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));
            }elseif(!empty($isSameAllDimension) && !empty($countTruePerProcess)){
                return view('check',compact('RMTruePerProcess','countTruePerProcess','isSameAllDimension','displayRangeValues','computedArray','isArrayResultPerModelMixing','checkedProperties','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));
            }else{
                return view('check',compact('displayRangeValues','computedArray','isArrayResultPerModelMixing','checkedProperties','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

            }
       }else{
            $displayRangeValues =[];
            return view('check',compact('displayRangeValues','isArrayResultPerModelMixing','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

       }

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
            dump("one: alreadylowered".$modified_process );
            if (Schema::hasTable(strtolower($modified_process))) {
                //Get specifications per table
                $specification = DB::table(strtolower($modified_process))
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
