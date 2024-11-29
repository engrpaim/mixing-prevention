<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Check Mixing</title>
</head>
<body>
    @include('components.all-nav')
    <div class="flex flex-col items-center justify-center">
        <div class="flex flex-col items-center justify-center w-screen p-5 m-10 shadow-xl rounded-xl outline outline-1 outline-slate-300">

            <form name="model_check" id="model_check" method="POST" action="{{ url('model-check-data') }}">
                @csrf
                <div class="flex flex-col items-start self-start">
                    <h2 class="font-bold">MODEL SPECIFICATION</h2>
                  </div>
                <div class="flex flex-col items-center justify-center">
                    <div class="flex flex-row">
                        <div class="flex flex-col items-center justify-center">
                            <x-selectdropdown
                                label="Model"
                                column="model"
                                show="NO"
                                title=""
                                :array="$modelDetails"
                            />
                        </div>
                        <div class="flex flex-col">
                            <x-submit-button type="submit" onclick="" style="block;"  id="check_mixing" name="check_mixing">Get data</x-submit-button>
                        </div>

                    </div>

                    <div class="flex flex-col">
                        @php
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

                            //array specs
                            if(isset($OPIFormadetails) && empty($OPIFormadetails)) {
                                $OPIFormadetails = [];
                            }
                            $computedTolerance = [];
                            $dimensionProcessesArray = [];

                        @endphp
                        @if(isset($specificationArray))

                            @foreach ($specificationArray as $key => $value)
                                @php
                                    $AllDetails = '';
                                @endphp
                                @foreach($specificationArray[$key] as $dataKey => $dataValue)
                                    {{--@dump($dataKey." --- ".$dataValue) --}}

                                    @if(array_key_exists($dataKey,$valuePerData))
                                        @if (str_contains($dataKey,"_val"))
                                            @php
                                                $baseLabel = explode("_",$dataKey);
                                                $baseLabel = $baseLabel[0];
                                                $actualSpecValue = $dataValue;
                                                $valueDataLabeled = $dataValue.$valuePerData[$dataKey];
                                                $computedTolerance[$baseLabel.'_base']= $actualSpecValue;
                                            @endphp
                                        @else
                                            @if(str_contains($dataKey,"_min"))
                                                @php
                                                    $minTol = $dataValue;
                                                @endphp
                                            @else
                                                @php
                                                    $maxTol = $dataValue;
                                                @endphp
                                                @if ( $minTol ==  $minTol)
                                                    @php
                                                        $actualMinValue = $actualSpecValue - $dataValue;
                                                        $computedTolerance[$baseLabel.'_min']= $actualMinValue;
                                                        $actualMaxValue = $actualSpecValue + $dataValue;
                                                        $computedTolerance[$baseLabel.'_max']= $actualMaxValue;
                                                        $specsFinalDetails = $valueDataLabeled."±".$dataValue;
                                                    @endphp
                                                        @if ($AllDetails != '')
                                                            @php
                                                                $AllDetails = $AllDetails." x ".$specsFinalDetails;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $AllDetails = $AllDetails.$specsFinalDetails;
                                                            @endphp
                                                        @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                @php
                                    $dimensionProcessesArray[$key] = $computedTolerance;
                                    $OPIFormadetails[$key] = $AllDetails;

                                @endphp
                            @endforeach
                        @endif
                        {{--@dump($dimensionProcessesArray)--}}
                    </div>
                </div>
            </form>
            @if (isset($selectedModel))
            <form name="mixing_check" id="mixing_check" method="POST" action="{{ url('mixing-check-data') }}">
                @csrf
                <div class="flex flex-col items-center justify-center p-4 bg-slate-50 outline outline-1 outline-gray-200 rounded-2xl">
                    <div class="flex flex-row px-20 pt-10 space-x-10">
                        <div class="flex flex-row">
                            @if (isset($selectedModel))
                            <table>
                                <tr >
                                    <th colspan="2" class ="px-2 py-2 text-center border border-slate-300">DIMENSION&nbsp;CRITERIA&nbsp;<i><u>{{ $selectedModel }}</u></i></th>
                                </tr>
                                    @php
                                        $count = 0;
                                        $currentDimensionFlow = explode(";",$readFlow);
                                    @endphp
                                    @if (!empty($OPIFormadetails))
                                        @foreach ($OPIFormadetails as $dimensionKey => $dimensionValue)
                                        <tr>
                                            <td  class = "px-2 py-2 text-sm border border-slate-300">{{ $currentDimensionFlow[$count] }}</td>
                                            <td  class = "px-2 py-2 text-sm border border-slate-300">{{ $dimensionValue }}</td>
                                        </tr>
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach
                                    @endif



                            </table>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <div class="flex flex-col ">
                            @if (isset($selectedModel))
                                <table>
                                    <tr >
                                        <th colspan="2" class ="px-2 py-2 text-center border border-slate-300">MATERIAL&nbsp;FINISH&nbsp;<i><u>{{ $selectedModel }}</u></i></th>
                                    </tr>
                                    <tr>
                                        <th  class = "px-2 py-2 text-base border text-start border-slate-300">Material(Before)</th>
                                        <td  class = "px-2 py-2 text-sm border border-slate-300">{{ $Before }}</td>
                                    </tr>
                                    <tr>
                                        <th  class = "px-2 py-2 text-base border text-start border-slate-300">Material(After)</th>
                                        <td  class = "px-2 py-2 text-sm border border-slate-300">{{ $After }}</td>
                                    </tr>
                                    <tr>
                                        <th  class = "px-2 py-2 text-base border text-start border-slate-300">Finish</th>
                                        <td  class = "px-2 py-2 text-sm border border-slate-300">{{ $Finish }}</td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <x-submit-button type="submit" onclick="" style="block;"  id="check_mixing" name="check_mixing">Check mixing</x-submit-button>
                </div>
                <input type="hidden" id="after_cm" name="after_cm" value="{{ $After }}"/>
                <input type="hidden" id="before_cm" name="before_cm" value="{{ $Before }}"/>
                <input type="hidden" id="finish_cm" name="finish_cm" value="{{ $Finish }}"/>
                <input type="hidden" id="model_cm" name="model_cm" value="{{ $selectedModel }}"/>
                <input type="hidden" id="readFlow_cm" name="readFlow_cm" value="{{ $readFlow }}"/>
                @if (!empty($OPIFormadetails))
                    @foreach($OPIFormadetails as $keys => $values)
                        <input type="hidden" id="OPIFormadetails_cm" name="OPIFormadetails_cm[{{  $keys }}]" value="{{ $values }}">
                    @endforeach
                @endif
                @if (!empty($dimensionProcessesArray))
                    @foreach($dimensionProcessesArray as $tableKey=>$tableValue)
                        @foreach ($tableValue as $dataPerColKey => $dataPerColValue)
                            <input type="hidden" id="dimensionProcessesArray_cm" name="dimensionProcessesArray_cm[{{ $tableKey }}][{{  $dataPerColKey }}]" value="{{ $dataPerColValue }}">
                        @endforeach
                    @endforeach
                @else

                    @foreach ( $dimensionReDisplay as $newDimensionArray)
                        @php
                            $dimensionProcessesArray = $newDimensionArray;
                            //dump($dimensionProcessesArray);
                        @endphp
                        @foreach($dimensionProcessesArray as $tableKey=>$tableValue)
                            @foreach ($tableValue as $dataPerColKey => $dataPerColValue)
                                <input type="hidden" id="dimensionProcessesArray_cm" name="dimensionProcessesArray_cm[{{ $tableKey }}][{{  $dataPerColKey }}]" value="{{ $dataPerColValue }}">
                            @endforeach
                        @endforeach
                    @endforeach
                @endif
               {{--@dump('hello'.session('dimensionProcessesArray')) --}}

            </form>
        </div>

        @if(isset($checkedProperties))
        <div class="flex flex-col items-center justify-center w-screen p-5 shadow-md rounded-xl outline outline-1 outline-slate-300">
            <table>
                @php
                    $tableSpecification = "px-2 py-2 text-sm border text-start border-slate-300";
                @endphp
                <thead >
                    <tr>
                        <th rowspan="2" class="{{ $tableSpecification }}" >COMMON&nbsp;MODEL</th>
                        <th colspan="2" class="px-2 py-2 text-base text-center border border-slate-300" >MATERIAL</th>
                        <th rowspan="2" class="px-2 py-2 text-base text-center border border-slate-300" >FINISH</th>
                        @foreach ( $currentDimensionFlow as $dimensTitleTable )
                            @if ($dimensTitleTable != "")
                                <th rowspan="2" class="{{ $tableSpecification }}" >{{ $dimensTitleTable }}</th>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th rowspan="2" class="{{ $tableSpecification }}" >AFTER&nbsp;MATERIAL</th>
                        <th rowspan="2" class="{{ $tableSpecification }}" >BEFORE&nbsp;MATERIAL</th>
                    </tr>
                </thead>
                <tbody>
                        @php
                            $displayMixingChecked = [];
                            $specsDimensionPropertyValues =  ['model','before','after','finish'];
                        @endphp
                        @if(isset($checkedProperties) && !empty($checkedProperties))
                            @foreach ( $checkedProperties  as $propertyList)
                                @foreach ($propertyList as $propertyKey => $propertyValue )
                                    @php
                                        //model,before,after,finish
                                        if(in_array($propertyKey, $specsDimensionPropertyValues)){
                                            if($propertyKey === 'model'){
                                                $modelArray = $propertyValue;
                                                $displayMixingChecked [$modelArray][$propertyKey] =  $propertyValue;
                                            }else{
                                                $displayMixingChecked [$modelArray][$propertyKey] = $propertyValue;
                                            }
                                        }
                                    @endphp
                                    @if($propertyKey === 'finish')
                                        <tr>
                                            @foreach ( $displayMixingChecked as $dataDisplay )
                                                {{--@dump($dataDisplay) --}}
                                                @php
                                                    $afterSameBgColor = ($dataDisplay['after'] == $After) ? 'bg-blue-200' : '';
                                                    $beforeSameBgColor = ($dataDisplay['before'] == $Before) ? 'bg-red-200' : '';
                                                    $finishBgColor = ($dataDisplay['finish'] == $Finish) ? 'bg-orange-200' : '';
                                                @endphp
                                                <th class="{{ $tableSpecification  }}" >{{ $dataDisplay['model'] }} </th>
                                                <th class="{{ $tableSpecification  }} {{ $beforeSameBgColor }}" >{{ $dataDisplay['before'] }} </th>
                                                <th class="{{ $tableSpecification  }} {{ $afterSameBgColor }}" >{{ $dataDisplay['after'] }} </th>
                                                <th class="{{ $tableSpecification  }} {{ $finishBgColor }}" >{{ $dataDisplay['finish'] }} </th>
                                            @endforeach
                                            @foreach ( $currentDimensionFlow as $dimensTitleTable )
                                                @if ($dimensTitleTable != "")
                                                    <th class="{{ $tableSpecification  }}" ></th>
                                                @endif
                                            @endforeach
                                        </tr>
                                        @php
                                        $displayMixingChecked=[];
                                        @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                        {{-- <th class="{{ $tableSpecification }}" >{{ $propertyValue }}</th> --}}
                </tbody>
            </table>
        </div>
        @endif
        @endif
    </div>
</body>
</html>
@dump(get_defined_vars())
