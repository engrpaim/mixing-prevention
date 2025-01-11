<?php

namespace App\Http\Controllers;

use App\Models\AfterMaterialModel;
use App\Models\BeforeMaterialModel;
use App\Models\specifications;
use App\Models\AddModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewList extends Controller
{
    protected $isGetProcesses;
    protected $isGetAllModel;
    protected $isGetAfterMaterial;
    protected $isGetBeforeMaterial;

    public function __construct()
    {
        $this->isGetProcesses = specifications::orderBy('specification','asc')->get();
        //$allBeforeMaterial = specifications::orderBy('updated_at', 'desc')->paginate(7, ['*'], 'wiew-list-page');
        $this->isGetAllModel = AddModel::orderBy('model','asc')->paginate(10, ['*'], 'wiew-list-page');
        $this->isGetBeforeMaterial = BeforeMaterialModel::orderBy('before_material','asc')->get();
        $this->isGetAfterMaterial = AfterMaterialModel::orderBy('after_material','asc')->get();
    }


    public function CheckBoxProcess(Request $request){
        function convertSpecial($tableName){
            $remove_special= preg_replace('/[^\w\s]/', '%', $tableName);
            $remove_special = str_replace('_', '%', $remove_special);
            return strtolower($remove_special);
        }


        $displayInSelectafterMaterial = $this->isGetAfterMaterial;
        $displayInSelectbeforeMaterial = $this->isGetBeforeMaterial;
        $output = '';
        $outputModel = '';
        $outputFlow = '';
        $query = $request->input('query', '');
        $isDisplayCheckBox =  $this->isGetProcesses;
        $isDisplayAllmodell = $this->isGetAllModel;

        $colorsCounter = 0;
        if($request->ajax())
        {

            $searchData = DB::table('add_models')
                            ->where('model','like','%'.$query.'%')
                            ->get();
            //dd($searchData);
            $colors = ["green" , "violet","red","blue","yellow","pink"];
            if(count($searchData) > 0){
                foreach($searchData as $row)
                {

                    $outputModel = '
                    <tr>
                        <td class="px-4 py-2 text-left border border-blue-500">'.$row->model.'</td>
                    ';
                    $AjaxProcessFlow = explode(";",$row->process_flow);
                    $outputFlow = '';
                    foreach($AjaxProcessFlow as $AjaxPerProcess){
                        if($AjaxPerProcess != ''){
                            $uniqueId = "{{ " .$row->model . '_' . $colorsCounter." }}";
                            $colorIndex = $colorsCounter % count($colors);
                            //Generate buttons when search is available
                            $outputFlow .= '

                                <button
                                    type="button"
                                    onclick="changeUrl(\'' . $row->model . '\', \'' . convertSpecial($AjaxPerProcess) . '\')"
                                    id="'.$row->model.'_'.$AjaxPerProcess.'" name="'.$row->model.'_'.$AjaxPerProcess.'"
                                    class="p-2 mx-1 my-2 text-xs font-bold text-'.$colors[$colorsCounter].'-700 bg-'.$colors[$colorsCounter].'-100 rounded outline outline-2 outline-'.$colors[$colorsCounter].'-500">'.$AjaxPerProcess.'</button>

                            ';

                            $colorsCounter ++;
                        }

                    }
                    $colorsCounter = 0 ;
                    $output .= $outputModel . "<td class='border border-blue-500 '>".$outputFlow."</td>"."</tr>";
                }

                $output .= " <script>
                                    function changeUrl(model, processFlow) {
                                        var encodedModel = encodeURIComponent(model);
                                        var encodedProcessFlow = encodeURIComponent(processFlow);
                                        var newUrl = '/viewlist/details/' + encodedModel + '/' + encodedProcessFlow;
                                        window.location.href = newUrl;
                                    }
                            </script>";

                $data = array(
                    'table_data'  => $output,
                   );

                   echo json_encode($data);
            }
        }else{


            return view('list',compact('isDisplayCheckBox','isDisplayAllmodell','displayInSelectafterMaterial','displayInSelectbeforeMaterial','displayInSelectafterMaterial','displayInSelectbeforeMaterial'));
        }

    }

    public function FinModelRange(Request $request){

        $before_mats = $request->input('before_mats');
        $after_mats = $request->input('after_mats');
        $search_mats = ['before' => $before_mats , 'after' => $after_mats  ];
        $AllCommonMaterials=[];
        if( !empty($search_mats)){
            foreach($search_mats  as $toSearchKey => $toSearchValue){
                if($toSearchValue != ''){
                    $isSameMaterial = DB::table('add_models')
                                            ->where($toSearchKey,"=", $toSearchValue)
                                            ->select('model')
                                            ->get();

                    foreach($isSameMaterial as $commonData){
                        $AllCommonMaterials  [$toSearchKey][$commonData->model]= $toSearchValue;
                    }
                }
            }
        }

        $isDisplayCheckBox =  $this->isGetProcesses;
        $displayInSelectafterMaterial = $this->isGetAfterMaterial;
        $displayInSelectbeforeMaterial = $this->isGetBeforeMaterial;
        $isHaveTargetValue =[];
        $specs = ['length','width','outer_radius','thickness','inner_radius','a'];
        $AllData= $request->all();
        foreach($AllData as $key => $value){
            if(in_array($key,$specs)&& $value != null || in_array($key,$specs)&& $value != 0){
                if($key == 'outer_radius'){
                    $key = "OR";
                }elseif($key == 'inner_radius'){
                    $key = "IR";
                }
                array_push($isHaveTargetValue,strtoupper($key));
                //dump($isHaveTargetValue);
            }
        }
       $countSpecsCurrent = 0;
       $queryAllSpecs = '';
       $allDimensionsValue = [];
       $allWithinSpecsModels = [];
       $buttonModels = [];
       $allModel = 0;
       $specificationsVal = ['length_val','width_val','thickness_val','ir_val','or_val','a_val'];
       foreach($AllData as $boxKey => $boxValue){

            if(str_contains($boxKey,"_checkBox")){
                $tableName = explode("_checkBox",$boxKey)[0];
                $remove_special= preg_replace('/[^\w\s]/', '%', $tableName);
                $remove_special = str_replace('_', '%', $remove_special);

                $parameters = explode(";",$boxValue);
                $toSearch = array_intersect($isHaveTargetValue,$parameters);


                if(!empty($toSearch)){

                    // dump($remove_special);
                    // dump( count($toSearch));
                    foreach( $toSearch as $compareToGetKey){
                        $countSpecsCurrent++;

                        if($compareToGetKey == 'OR'){
                            $compareToGetKey = "outer_radius";
                        }elseif($compareToGetKey == 'IR'){
                            $compareToGetKey = "inner_radius";
                        }

                        $computedMax = $AllData[strtolower($compareToGetKey)] + $AllData[strtolower($compareToGetKey)."_max"];
                        $computedMin = $AllData[strtolower($compareToGetKey)] - $AllData[strtolower($compareToGetKey)."_min"];

                        if($compareToGetKey == 'outer_radius'){
                            $compareToGetKey = "OR";
                        }elseif($compareToGetKey == 'inner_radius'){
                            $compareToGetKey = "IR";
                        }

                        $valueSearch = strtolower($compareToGetKey);
                        if($countSpecsCurrent != count($toSearch)){
                            $queryAllSpecs .= $valueSearch."_val >= " .$computedMin." AND ".$valueSearch."_val <= ".$computedMax." OR ";
                        }elseif($countSpecsCurrent == count($toSearch)){
                            $countSpecsCurrent = 0;
                            $queryAllSpecs .= $valueSearch."_val >= " .$computedMin." AND ".$valueSearch."_val <= ".$computedMax;
                            try{
                                //dump($queryAllSpecs);
                                $isWithinSpecs = DB::table(strtolower($remove_special))
                                ->whereRaw($queryAllSpecs)
                                ->get();

                                foreach($isWithinSpecs as $datakey => $dataValue){
                                    $comBindAllTrue = '';
                                    foreach($specificationsVal as $isValueInclude){
                                        if(property_exists($dataValue,$isValueInclude) && $dataValue->$isValueInclude > 0){
                                            $targetVal = $dataValue->$isValueInclude.strtoupper(substr($isValueInclude,0,1));
                                            if($targetVal == "O"){
                                                $targetVal =="OR";
                                            }elseif($targetVal == "I"){
                                                $targetVal =="IR";
                                            }
                                            $specsTarget = explode("_",$isValueInclude)[0];
                                            $minProp = $specsTarget."_min";
                                            $maxProp = $specsTarget."_max";
                                            $minVal = $dataValue->$minProp;
                                            $maxVal = $dataValue->$maxProp ;
                                            if($minVal == $maxVal ){
                                                if($comBindAllTrue == ''){
                                                    $comBindAllTrue .= $targetVal ."±".$maxVal;
                                                }else{
                                                    $comBindAllTrue .=" X ".$targetVal ."±".$maxVal;
                                                }


                                            }else{

                                                if($comBindAllTrue == ''){
                                                    $comBindAllTrue .= $targetVal ."±".$maxVal."/".$minVal;
                                                }else{
                                                    $comBindAllTrue .=" X ".$targetVal ."±".$maxVal."/".$minVal;
                                                }


                                            }

                                        }
                                    }
                                    $allDimensionsValue [$remove_special][$dataValue->model]= $comBindAllTrue;
                                    //dump($allDimensionsValue);

                                }
                                //$allDimensionsValue [$remove_special] = $isWithinSpecs;
                                //dump($isWithinSpecs);
                            }catch(\Exception $e){
                                dd($e);
                            }
                            //$allWithinSpecsModels

                            foreach($isWithinSpecs as $data ){

                                $countSpecsCurrent++;
                                $allWithinSpecsModels [$remove_special][$data->model]=  $data;
                                if(!in_array($data->model ,$buttonModels )){
                                    $buttonModels []= $data->model;
                                }


                            }
                            // dump($buttonModels);
                            // dump($allWithinSpecsModels);
                            //dump($queryAllSpecs ." \n ".'RESET 0 == '.$countSpecsCurrent);
                            $countSpecsCurrent = 0;
                            $queryAllSpecs = '';

                        }

                        // dump($compareToGetKey." MAX: ".$computedMax);
                        // dump($compareToGetKey." MIN: ".$computedMin);
                    }

                }
            }

       }


        //get all dimension flow
        $allDimensionFlow = [];
        $allSpecsValue = [];
        foreach( $buttonModels as $getData){
            // dump($getData);
            try{
            $isGetProcesses = AddModel::where('model', $getData)->first();
            $allDimensionFlow [$isGetProcesses->model] = $isGetProcesses->process_flow;

            //dump($isGetProcesses->process_flow);

            $getAllDimensionsPerProcess = explode(";",$isGetProcesses->process_flow);

            foreach($getAllDimensionsPerProcess  as  $specificDataPorcess){
                if($specificDataPorcess != ''){

                    try{
                        $remove_special2 = preg_replace('/[^\w\s]/', '%', $specificDataPorcess);
                        $remove_special2 = str_replace('_', '%', $remove_special);
                        //dump("|||||->>>>>>>>>> ".$remove_special2);
                        $data = DB::table(strtolower($remove_special))
                                ->where('model', $isGetProcesses->model)
                                ->get();
                                //dump($data[0]);
                                if(isset($data[0]) && !empty($data[0])){
                                    $allSpecsValue [$isGetProcesses->model][$specificDataPorcess]= $data[0];
                                }
                    }catch(\Exception $e){
                        continue;
                    }
                }
            }
        }catch(\Exception $e){
            continue;
        }


        }
       // dump($AllCommonMaterials );
       if(!empty($allDimensionFlow)){

            return view('list',compact('isDisplayCheckBox','AllCommonMaterials','allWithinSpecsModels','buttonModels','allDimensionFlow','allDimensionsValue','displayInSelectafterMaterial','displayInSelectbeforeMaterial'));

       }else{

            return view('list',compact('isDisplayCheckBox','allWithinSpecsModels','buttonModels','displayInSelectafterMaterial','displayInSelectbeforeMaterial','AllCommonMaterials'));

       }



    }

    public function showDetails($model, $table){

        $removeWhite = str_replace(" ","%",$table);

        try{

            $getSpecs = DB::table($removeWhite)
                            ->where('model',$model)
                            ->get();

            if(count($getSpecs) > 0){

                return redirect('/list')->with([
                    "viewlistSpecs" => [$table => $getSpecs]
                ]);

            }else{

                return redirect('/list')->with([
                    "Error404" => "Specifications not found"
                ]);

            }

        }catch(\Exception $e){

            return redirect('/list')->with([
                "Unknown" => $e
            ]);

        }


    }

    public function updateModel(Request $request){

       $allData = $request->all();
       $updateData = [];
       foreach($allData as $dataKey => $dataValue){
            if($dataKey != 'tableFind' && $dataKey != '_token'){
                $updateData [$dataKey] = $dataValue;
            }elseif($dataKey == 'tableFind'){
                $dataValue = str_replace(" ","%", $dataValue);
                $tableUpdate = $dataValue;
            }
       }

       if ($tableUpdate && !empty($updateData)) {
            try{
                $isupdatedModel = DB::table($tableUpdate)
                ->where('model', $request->model)
                ->update(array_merge($updateData, ['updated_at' => now(), 'ip_address' => request()->ip()]));
            }catch(\Exception  $e){
                dd($e);
            }


        }
        return redirect('/list');
    }
}


