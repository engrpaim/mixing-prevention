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
                $displayRangeValues[$passedDataKey] =(float) $passedDataValue;
            }

        }

        // dump($displayRangeValues);
        // dump(  $request->all());
        $readFlow = $request->input('readFlow_cm');
        $selectedModel = htmlspecialchars($request->input('model_cm'));
        $modelDetails = $this->Models;
        $Before = $request->input('before_cm');
        $After  = $request->input('after_cm');
        $Finish = $request->input('finish_cm');
        $OPIFormadetails = $request->input('OPIFormadetails_cm');
        $RMTruePerProcess = [];
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

        $checkerDimension = ['length' , 'width' . 'thickness' , 'ir' , 'or' , 'a'];

        $notCurrentModel = " AND model NOT LIKE '".$selectedModel."' ";
        $isEqualQuery = '';


        if(isset($extractTableToCheck) && !empty($extractTableToCheck)){
            $currentFlowCount = 0;
            foreach($extractTableToCheck as $singleKey => $singleValue){
                // dump($singleKey , $singleValue);

                $queryData = '';
                $checkMixing = '';
                //collect target value key in array
                $allSpecsInCurrentProcess = [];
                $allSpecsInval = [];//data specs to be get used in@getdata
                foreach($singleValue as $keyPerProcess => $valuePerProcess){
                    if(str_contains($keyPerProcess,"_base")){
                        array_push($allSpecsInCurrentProcess ,$keyPerProcess );
                        $perVal = explode("_",$keyPerProcess)[0] . "_val";
                        array_push($allSpecsInval,$perVal);
                        // dump($allSpecsInval);
                    }
                }

                //collect  all array key to query
                $countallSpecsInCurrentProcess = count($allSpecsInCurrentProcess) ;
                $currentCount = 0 ;

                foreach($allSpecsInCurrentProcess as $CurrentTableSpecs){

                    $currentCount++;
                    $specs  = explode("_",$CurrentTableSpecs)[0];

                    if($specs == 'length'){
                        $range = $displayRangeValues['length_range'];
                    }elseif($specs == 'width'){
                        $range = $displayRangeValues['width_range'];
                    }elseif($specs == 'thickness'){
                        $range = $displayRangeValues['thickness_range'];
                    }else{
                        $range = $displayRangeValues['radius_range'];
                    }

                    $minimum = $singleValue[$specs."_min"] - $range;
                    $maximum = $singleValue[$specs."_max"] + $range;

                    if($countallSpecsInCurrentProcess !==  $currentCount ){

                        $checkMixing .=  "(`".$specs."_val` >= " . $minimum . " AND `" . $specs ."_val` <= ".$maximum. ") OR ";
                        $queryData  .= "CASE WHEN " . $specs."_val BETWEEN " . $minimum . " AND " . $maximum ." THEN 1 ELSE 0 END AS `".$specs. "`,";


                    }else{

                        $checkMixing .=  "(`".$specs."_val` >= " . $minimum . " AND `" . $specs ."_val` <= ".$maximum . ")";
                        $queryData  .= "CASE WHEN " . $specs."_val BETWEEN " . $minimum . " AND " . $maximum ." THEN 1 ELSE 0 END AS `".$specs."`";

                    }

                }
                //  $queryData .= ' WHERE `model` NOT LIKE `'.$selectedModel.'`';
                //  $checkMixing .= 'AND NOT LIKE `'.$selectedModel.'`';
                // dump($checkMixing);
                // dump($queryData);
                // dump($allSpecsInCurrentProcess);
                // dump('setting the value');


                dump($allSpecsInval);
                dump(count($allSpecsInval));
                if(count($allSpecsInval) == 3){
                    if($singleKey == 'C%TYPE%%R%'){

                        $matchHaving = '`ir` = 1 AND `or` = 1 AND `a` = 1';

                    }elseif($singleKey == 'RAW%MATERIAL'){

                        if(in_array("or_val",$allSpecsInval)){

                            $matchHaving = 'length = 1 AND width = 1 AND thickness = 1 or ir = 1 AND `or` = 1 ';

                        }else{

                            $matchHaving = 'length = 1 AND width = 1 AND thickness = 1  ';

                        }


                    }else{

                        $matchHaving = 'length = 1 AND width = 1 AND thickness = 1';

                    }
                }elseif(count($allSpecsInval) == 2){

                    $dynamicAll = '';
                    $dynamicPerValue = '';
                    foreach($allSpecsInval as $dynamic){
                        $dynamicPerValue = explode('_',$dynamic)[0]. " = 1 ";
                        if($dynamicAll == ''){
                            $dynamicAll .= $dynamicPerValue;
                        }else{
                            $dynamicAll .= "AND ".$dynamicPerValue;
                        }

                    }
                    $matchHaving = $dynamicAll;


                }

                  dump( $matchHaving);




                try{

                    $isEqualAllDimension = DB::table(strtolower($singleKey))
                                            ->selectRaw('model, '.$queryData)
                                            ->havingRaw($matchHaving)
                                            ->get();

                    foreach($isEqualAllDimension as $allKey){
                        // dump($selectedModel , $allKey->model);

                            // dump('not like model');

                            $isSameAllDimension[$allKey->model][$currentFlowCount."_allsame"] = $currentFlowCount;

                    }


                }catch(\Exception $e){

                    dd($e);
                    continue;

                }
                //get all specs if >= 1 in specs is true
                try{

                    $allMixingDimension = DB::table(strtolower($singleKey))
                                                ->whereRaw($checkMixing)
                                                ->get();


                }catch(\Exception $e){
                      dd($e);
                    continue;
                }

                foreach($allMixingDimension as $dataPerModel){
                    //$computeDifference = abs( floatval($singleValue[$specs."_base"]));
                    $LegenCompile = '';
                    $currentModel = '';
                    $countPerValue = 0;
                    $RmCount = 0;
                    //@getdata

                    foreach($allSpecsInval as $specsMinMax)
                    {

                        //model
                        $specsModel =  $dataPerModel->model;

                            if($specsModel !=  $currentModel){
                                //@get_model_details
                                $currentModel = $specsModel;
                                // dump($currentModel );

                                try{

                                    $getData = DB::select('SELECT `before`, `after`, `type`, `finish` FROM `add_models` WHERE `model` = ?', [$currentModel]);



                                    // dump($getData);

                                }catch(\Exception $e){
                                    dump($e);
                                    continue;
                                }

                                if($getData){

                                    $isArrayResultPerModelMixing[$specsModel]['before'] =  $getData[0]->before;
                                    $isArrayResultPerModelMixing[$specsModel]['after'] =  $getData[0]->after;
                                    $isArrayResultPerModelMixing[$specsModel]['type'] =  $getData[0]->type;
                                    $isArrayResultPerModelMixing[$specsModel]['finish'] =  $getData[0]->finish;

                                }
                            }


                            //@compute_dimension
                            //data per model  values
                            $specsGet = explode("_",$specsMinMax)[0];
                            $specsLegend = strtoupper($specsGet[0]);
                            $specsGetMin =  $specsGet. "_min";
                            $specsGetMax =  $specsGet. "_max";

                            //compute
                            $isToSubtractTarget = (float)$singleValue[$specsGet."_base"];
                            $valueTarget = $dataPerModel->$specsMinMax;
                            $absoluteDifferenceTarget = round(abs($isToSubtractTarget - $valueTarget ),3);
                            $isArrayResultPerModelMixing [$specsModel][$currentFlowCount."_".$specsGet."_compareTarget" ] = $valueTarget ." - ".$isToSubtractTarget." = " .$absoluteDifferenceTarget;
                            $isNeedToHighlighted[$specsModel][$currentFlowCount."_".$specsGet] = $absoluteDifferenceTarget;

                            //@convertTodisplay
                            $legendMin = $dataPerModel->$specsGetMin;
                            $legendMax = $dataPerModel->$specsGetMax;

                            //specialcases OR and IR specs
                            if($specsLegend == 'I'){

                                $specsLegend = "IR";

                            }elseif($specsLegend == 'O'){

                                $specsLegend = "OR";

                            }

                            if($legendMin == $legendMax && $LegenCompile == ''){

                                $LegenCompile = $valueTarget . $specsLegend." ± ". $legendMax;

                            }elseif($legendMin != $legendMax && $LegenCompile == ''){

                                $LegenCompile = $valueTarget . $specsLegend." ± ". $legendMax."/-".$legendMin;

                            }elseif($legendMin == $legendMax && $LegenCompile != ''){

                                $LegenCompile .=  " x " .$valueTarget . $specsLegend." ± ". $legendMax;

                            }elseif($legendMin != $legendMax && $LegenCompile != ''){

                                $LegenCompile .= " x ".$valueTarget . $specsLegend." ± ".$legendMax."/-".$legendMin;

                            }

                            //color rule
                            if($absoluteDifferenceTarget >= 0  && $absoluteDifferenceTarget <= 1.99 && $singleKey != 'raw%material'){
                                $countPerValue++;
                                $countTruePerProcess [$specsModel][$currentFlowCount ] = $countPerValue ;
                            }

                            if( $singleKey == 'RAW%MATERIAL'){
                                if( $absoluteDifferenceTarget >= 0 && $absoluteDifferenceTarget <= 3 ){
                                    $RmCount++;
                                    $RMTruePerProcess [$specsModel][$currentFlowCount ] = $RmCount ;
                                }elseif($absoluteDifferenceTarget >= 0 && $absoluteDifferenceTarget <= 2){
                                    $RmCount++;
                                    $RMTruePerProcess [$specsModel][$currentFlowCount ] = $RmCount ;
                                }

                            }

                    }

                    // dump($LegenCompile);
                    $isArrayResultPerModelMixing[$specsModel][$currentFlowCount."_dimension_process"] = $LegenCompile;


                }

                $currentFlowCount++;

            }

        }


        if(isset($isArrayResultPerModelMixing[$selectedModel])){
            unset($isArrayResultPerModelMixing[$selectedModel]);
        }
        if(isset($isSameAllDimension[$selectedModel])){
            unset($isSameAllDimension[$selectedModel]);
        }


            // dump( $RMTruePerProcess);


       if($isArrayResultPerModelMixing){

            if(!empty($isSameAllDimension) && empty($countTruePerProcess) ){

                return view('check',compact('isSameAllDimension','displayRangeValues','computedArray','isArrayResultPerModelMixing','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

            }elseif(!empty($isSameAllDimension) && !empty($countTruePerProcess) ){

                return view('check',compact('RMTruePerProcess','countTruePerProcess','isSameAllDimension','displayRangeValues','computedArray','isArrayResultPerModelMixing','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

            }else{

                return view('check',compact('displayRangeValues','computedArray','isArrayResultPerModelMixing','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

            }

       }else{

            $displayRangeValues =[];
            return view('check',compact('displayRangeValues','isArrayResultPerModelMixing','OPIFormadetails','modelDetails','selectedModel','readFlow','Before','After','Finish','dimensionReDisplay','mixingPerDimension'));

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
           // dump("one: alreadylowered".$modified_process );
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
