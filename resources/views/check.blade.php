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
    <div class="flex flex-col items-center justify-center p-10">

        <div class="flex flex-col items-center justify-center w-screen p-5 pb-10 m-10 shadow-xl rounded-xl outline outline-1 outline-slate-300">
            <div class="flex flex-row w-full p-2 mb-5 bg-blue-100 rounded-2xl outline outline-1 outline-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="mt-0.5">
                    <path d="m720-430 80 80v190q0 33-23.5 56.5T720-80H160q-33 0-56.5-23.5T80-160v-560q0-33 23.5-56.5T160-800h220q-8 18-12 38.5t-6 41.5H160v560h560v-270Zm52-174 128 128-56 56-128-128q-21 12-45 20t-51 8q-75 0-127.5-52.5T440-700q0-75 52.5-127.5T620-880q75 0 127.5 52.5T800-700q0 27-8 51t-20 45Zm-152 4q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29ZM160-430v270-560 280-12 22Z"/>
                </svg>
                <h1 class="text-xl font-bold text-center">MODEL DETAILS</h1>
            </div>
            <form name="model_check" id="model_check" method="POST" action="{{ url('model-check-data') }}">
                @csrf

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
                        @if(isset($specificationArray)  )

                            @foreach ($specificationArray as $key => $value)
                                @php
                                    $AllDetails = '';
                                    //dump($specificationArray[$key]);
                                    $counterForSpecs = 0;
                                    $counterCurrentLimit = 0;
                                @endphp
                            @if (isset($specificationArray[$key]) && !empty($specificationArray[$key]))
                            @foreach ($specificationArray[$key] as $keyCounters => $valueCounters )
                            @if(str_contains($keyCounters,"_val") || str_contains($keyCounters,"_max") || str_contains($keyCounters,"_min"))
                                    @php
                                    $counterForSpecs++;
                                    //dump($counterForSpecs);
                                    @endphp
                            @endif
                        @endforeach
                        @foreach($specificationArray[$key] as $dataKey => $dataValue)
                            {{--@dump($dataKey." --- ".$dataValue) --}}
                            {{--@dump($dataValue) --}}
                            @if(array_key_exists($dataKey,$valuePerData) && $dataValue > 0 && $counterForSpecs && $counterCurrentLimit <= $counterForSpecs )
                                @php
                                    $counterCurrentLimit++;

                                @endphp

                                @if (str_contains($dataKey,"_val"))
                                    @php
                                        $baseLabel = explode("_",$dataKey);
                                        $baseLabel = $baseLabel[0];
                                        $actualSpecValue = $dataValue;
                                        $valueDataLabeled = $dataValue.$valuePerData[$dataKey];
                                        $dimensionProcessesArray[$key][$baseLabel.'_base']= $actualSpecValue;
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
                                                $dimensionProcessesArray[$key][$baseLabel.'_min']= $actualMinValue;
                                                $actualMaxValue = $actualSpecValue + $dataValue;
                                                $dimensionProcessesArray[$key][$baseLabel.'_max']= $actualMaxValue;
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

                            @endif
                                @php
                                    //dump($dimensionProcessesArray);

                                    $OPIFormadetails[$key] = $AllDetails;

                                @endphp

                            @endforeach
                        @endif
                        {{--@dump($dimensionProcessesArray)--}}

                    </div>
                </div>

            </form>
            {{-- Detect range specs needed --}}
            @if (isset($selectedModel))
            @php
                $count = 0;
                $currentDimensionFlow = explode(";",$readFlow);
                $computedMaxCount = 0;
                $rangeInputArray = [];
            @endphp
            <form name="mixing_check" id="mixing_check" method="POST" action="{{ url('mixing-check-data') }}">
                @csrf
                {{-- Create specs for range based on maximum specs have--}}
                @if(isset($computedArray) && !empty($computedArray))
                    @foreach ( $computedArray as $computedKey => $computedValue )
                        @php

                            if($computedMaxCount == 0){
                                $computedMaxCount = count($computedValue);
                            }
                            if($computedMaxCount > $computedValue){
                                $computedMaxCount = count($computedValue);
                            }

                        @endphp
                        @foreach ($computedValue as $computedSpecsKey => $computedSpecsValue )
                            @if($computedMaxCount%2 == 0)
                                @php
                                    $specsRnageInput = explode("_",$computedSpecsKey);
                                    $specsRnageInput = $specsRnageInput[0];
                                @endphp
                                @if(!in_array($specsRnageInput,$rangeInputArray) )
                                    @php
                                        if($specsRnageInput == 'ir' or $specsRnageInput == 'or'){
                                            $specsRnageInput = 'radius';
                                            if(!in_array($specsRnageInput,$rangeInputArray)){
                                                $rangeInputArray []= $specsRnageInput;
                                            }
                                        }elseif($specsRnageInput != 'a'){
                                            $rangeInputArray []= $specsRnageInput;
                                        }
                                    @endphp
                                @endif

                            @endif

                        @endforeach

                    @endforeach
                    {{--@dump($rangeInputArray)--}}


                @endif
                {{-- Display model result --}}
                <div class="flex flex-col items-center justify-center p-4 bg-slate-50 outline outline-1 outline-gray-200 rounded-2xl">
                    <div class="flex flex-row">
                        <div class="flex flex-row px-5 py-10 space-x-10">

                            <div class="flex flex-row">
                                @if (isset($selectedModel))
                                <table>
                                    <tr >
                                        <th colspan="2" class ="px-2 py-2 text-center border border-slate-300">DIMENSION&nbsp;CRITERIA&nbsp;<i><u>{{ $selectedModel }}</u></i></th>
                                    </tr>

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

                        {{-- Display range needed per specs --}}
                        @if (isset($rangeInputArray) && !empty($rangeInputArray) )
                            <div class="flex flex-col justify-center w-64 p-4 m-3 bg-violet-200 rounded-2xl outline outline-2 outline-violet-500">

                                    <h1 class="p-2 font-bold text-center">RANGE</h1>


                                    @foreach ($rangeInputArray as $createInputRange )
                                        <div class="flex flex-row items-center justify-between w-56 p-1">
                                            <label class="text-left" for="{{ $createInputRange }}_range">{{ strtoupper($createInputRange) }}</label>
                                            <input type="number" id="{{ $createInputRange }}_range" name="{{ $createInputRange }}_range" class="w-32 p-1 text-center rounded-lg outline outline-1 outline-slate-300 hover:outline-blue-700 hover:outline-2 hover:bg-blue-50 focus:bg-blue-50 "/>
                                        </div>
                                    @endforeach


                            </div>
                        @endif
                    </div>




                    <x-submit-button type="submit" onclick="hideElement()" style=""  id="data_mixing" name="data_mixing">Check mixing</x-submit-button>


                </div>
                <input type="hidden" id="after_cm" name="after_cm" value="{{ $After }}"/>
                <input type="hidden" id="before_cm" name="before_cm" value="{{ $Before }}"/>
                <input type="hidden" id="finish_cm" name="finish_cm" value="{{ $Finish }}"/>
                <input type="hidden" id="model_cm" name="model_cm" value="{{ $selectedModel }}"/>
                <input type="hidden" id="readFlow_cm" name="readFlow_cm" value="{{ $readFlow }}"/>
                {{-- Repass all data from get_defined_vars() from previous form/controller --}}
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
                    @if(isset($dimensionReDisplay) && !empty($dimensionReDisplay) && isset($dimensionProcessesArray ) && !empty($dimensionProcessesArray ))
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
                @endif
               {{--@dump('hello'.session('dimensionProcessesArray')) --}}

            </form>
        </div>

        {{-- ----------------------------------------DISPLAY MIXING RESULT---------------------------------------------------------- --}}

        @if(isset($isArrayResultPerModelMixing))

            @if($isArrayResultPerModelMixing)
                <script type="text/javascript">
                    window.onload = function() {
                        document.getElementById("data_mixing").style.display = "none";
                    };
                </script>
            @endif

            <div class="flex flex-col items-center justify-center w-screen p-5 bg-white shadow-md rounded-xl outline outline-1 outline-slate-300">
                <div class="flex flex-row w-full p-2 mb-5 bg-blue-100 rounded-2xl outline outline-1 outline-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 mx-2" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                        <path d="M120-40q-33 0-56.5-23.5T40-120v-720q0-33 23.5-56.5T120-920h720q33 0 56.5 23.5T920-840v720q0 33-23.5 56.5T840-40H120Zm440-120h240v-240h-80v102L594-424l-57 57 127 127H560v80Zm-344 0 504-504v104h80v-240H560v80h104L160-216l56 56Zm151-377 56-56-207-207-56 56 207 207Z"/>
                    </svg>
                    <h1 class="text-xl font-bold text-center">MIXING DETAILS</h1>
                </div>
                <div class="w-fit">

                    {{-- Result table --}}
                    <table>
                        @php
                            $tableSpecification = "px-2 py-2 text-sm border text-center border-slate-300";
                        @endphp
                        <thead >
                            <tr>
                                <th rowspan="2" class="{{ $tableSpecification }}" >COMMON&nbsp;MODEL</th>
                                <th colspan="2" class="px-2 py-2 text-base text-center border border-slate-300" >MATERIAL</th>
                                @foreach ( $currentDimensionFlow as $dimensTitleTable )
                                    @if ($dimensTitleTable != "")
                                        <th rowspan="2" class="{{ $tableSpecification }}" >{{ $dimensTitleTable }}</th>
                                    @endif
                                @endforeach
                                <th rowspan="2" class="px-2 py-2 text-base text-center border border-slate-300" >FINISH</th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="{{ $tableSpecification }}" >AFTER&nbsp;MATERIAL</th>
                                <th rowspan="2" class="{{ $tableSpecification }}" >BEFORE&nbsp;MATERIAL</th>
                            </tr>
                        </thead>
                        <tbody>
                           {{--@dump($isArrayResultPerModelMixing)--}}
                           @if(empty($isArrayResultPerModelMixing) )
                                    <th colspan="{{ count($currentDimensionFlow)+4 }}" class="{{ $tableSpecification }} " >No data found</th>
                             @endif
                           @foreach ( $isArrayResultPerModelMixing as $resultKey => $resultValue)
                                <tr>

                                    <td class="{{ $tableSpecification }} " >{{ $resultKey }} </td>



                                        @if(isset($resultValue['after']))
                                            @php
                                                $afterSameBgColor = ($resultValue['after'] == $After) ? 'bg-blue-200' : '';
                                            @endphp
                                            <td class="{{ $tableSpecification }} {{ $afterSameBgColor }}" >
                                                {{ $resultValue['after'] }}
                                        @else
                                            <td class="{{ $tableSpecification }}" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                                <path d="M10.5 15L13.5 12M13.5 15L10.5 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                        @endif

                                            </td>



                                        @if(isset($resultValue['before']))
                                            @php
                                                $beforeSameBgColor = ($resultValue['before'] == $Before) ? 'bg-red-200' : '';
                                            @endphp
                                            <td class="{{ $tableSpecification }} {{ $beforeSameBgColor }}" >
                                                {{ $resultValue['before'] }}
                                        @else
                                            <td class="{{ $tableSpecification }}" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                            <path d="M10.5 15L13.5 12M13.5 15L10.5 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        @endif

                                            </td>

                                    @for ($z=0;$z < count($currentDimensionFlow)-1;$z++)
                                            <td class="{{ $tableSpecification  }}" >
                                            @if (isset($resultValue[$z.'_dimension_process']) && !empty($resultValue[$z.'_dimension_process']))
                                                {{ $resultValue[$z.'_dimension_process']  }}
                                            @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                                <path d="M10.5 15L13.5 12M13.5 15L10.5 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                            @endif
                                            </td>
                                    @endfor

                                    <td class="{{ $tableSpecification }} " >
                                        @if(isset($resultValue['finish']))
                                            {{ $resultValue['finish'] }}
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                                <path d="M10.5 15L13.5 12M13.5 15L10.5 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @endif
    </div>

</body>
</html>
{{--@dump(get_defined_vars()) --}}
