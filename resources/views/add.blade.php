<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta http-equiv="X-UA-Compatible" content="ie=edge" >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Mixing: Add</title>
</head>
<body>
    @include('components.all-nav')


    <div class="flex flex-col self-center w-screen m-auto my-10 text-base rounded-lg shadow-xl mt-14 h-fit shadow-gray-300 min-w-fit max-w-fit">
        <div   div class="flex justify-center w-full py-4 m-0 bg-blue-200 min-w-fit">
            <h1 class="font-bold">ADD: MODEL DETAILS</h1>
        </div>
        <div class="flex flex-col p-5 pt-0 font-semibold w-96 min-w-fit">
            @php
                $hoverSelect = "w-auto h-20 hover:bg-blue-200 hover:text-gray-700 hover:rounded-b-2xl ";
            @endphp
                <form name="add-model-form" id="add-model-form" method="POST" action="{{ url('add-model-data') }}">
                    @csrf
                    {{-- MODEL INFO--}}
                    <div class="flex flex-row items-center justify-center mx-2 mb-0">
                        <div class="flex flex-row mr-20 {{ $hoverSelect }}">
                            <div class="flex mt-4 mr-14">
                            <div class="flex-col mx-5 mt-3 min-w-fit ">
                                <label for="model_name" required>Model name:</label>
                            </div>
                            <div class="">
                                <input class="p-3 mx-2 rounded-lg shadow-lg max-h-fit outline outline-1 outline-gray-300 hover:bg-blue-100 hover:outline-blue-500 hover:outline-2" name="model_name" id="model_name" placeholder="add model here" required>
                            </div>
                        </div>
                        </div>
                        <div class="flex flex-row items-center justify-center">
                            @php
                            $dropDownData = [
                                [
                                    'label' => 'Material(Before):',
                                    'column' => 'before_material',
                                    'array' => $allBefore],
                                [
                                    'label' => 'Material(After):',
                                    'column' => 'after_material',
                                    'array' => $allMaterial],
                                [
                                    'label' => 'Finish:',
                                    'column' => 'finish',
                                    'array' => $allFinish
                                ],
                            ];
                            @endphp
                            @foreach ($dropDownData as $dropdown)
                                <div class="{{ $hoverSelect }}">
                                    <x-selectdropdown
                                        label="{{ $dropdown['label'] }}"
                                        column="{{ $dropdown['column'] }}"
                                        show="NO"
                                        title=""
                                        :array="$dropdown['array']"
                                    />
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="mx-2 mt-20">
                        <x-selectdropdown label="Select Process:" column="process" show="YES" title="PROCESS FLOW" :array="$allModel" />
                    </div>
                    <script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>

                </form>




            <form name="specs-model-form" id="specs-model-form" method="POST" action="{{ url('specs-model-data') }}" class="max-min-fit ">
                @csrf
                @php
                    $inputForadd = [
                        [
                            'type' => 'hidden',
                            'name' => 'selected_processes2'
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'model_name2'
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'finish_selected'
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'before_selected'
                        ],
                        [
                            'type' => 'hidden',
                            'name' => 'after_selected'
                        ],
                    ];
                @endphp
                @foreach ( $inputForadd as $inputData )
                    <input type="{{ $inputData['type'] }}" name="{{ $inputData['name'] }}" id="{{ $inputData['name'] }}">
                @endforeach



                <x-submit-button type="button" onclick="addSpecs()" style="block;" name="update" id="add_specs_btn">Add specs</x-submit-button>

                <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
                <script type="text/javascript" src="{{ asset('js/processFlow.js') }}"></script>
            </form>


        </div>
        @if (session('processedData'))
        <script text="text/javascript" src="{{ asset('js/hide.js') }}">
        </script>
        <div class="flex flex-col items-center justify-center p-10 mb-10 ">

        <form name="add-specs-form" id="add-specs-form" method="POST" action="{{ url('add-specs-data') }}" >
            @csrf
            @php
                $allProcessesData = '';
            @endphp
            @foreach ( session('processedData') as $combine )
                @foreach ( $combine as $combineKey => $combineValue )

                        @php
                            $allProcessesData = $allProcessesData . $combineValue . ";";
                        @endphp

                @endforeach

            @endforeach
            {{--@dump( $allProcessesData)--}}

            <input type="hidden" name="selected_processes3" id="selected_processes3" value="{{ $allProcessesData }}" >
            <div class="flex flex-row items-center justify-center">

                <div class="flex flex-row justify-between mx-10">
                    @php
                        $selectedDetails = [
                            [
                                'title' => 'Model:',
                                'session' => 'modelName',
                                'id' => 'add_model',
                            ],
                            [
                                'title' => 'Finish:',
                                'session' => 'finish',
                                'id' => 'finish_category',
                            ],
                            [
                                'title' => 'Material(After):',
                                'session' => 'after',
                                'id' => 'after_details',
                            ],
                            [
                                'title' => 'Material(Before):',
                                'session' => 'before',
                                'id' => 'before_details',
                            ],
                        ];
                    @endphp

                    @foreach ( $selectedDetails  as $targetValues )
                        <div class="flex flex-col h-10 p-2 m-10 shadow-lg min-w-80 max-w-fit rounded-xl outline outline-1 outline-slate-200">
                            <div  class="flex flex-row items-center justify-center">
                                <span class="font-bold">{{ $targetValues['title'] }}&nbsp;&nbsp;</span>
                                <span >{{ session($targetValues['session']) }}</span>
                                <input type="hidden" name="{{ $targetValues['id']  }}" id="{{ $targetValues['id'] }}" value="{{ session($targetValues['session'] )}}"/>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>



        <div class="flex flex-col items-center justify-center ">
            <x-specstable :fourth="4"/>
        </div>
        @php
            $newSpecsTable = [
                2 => 5,
                4 => 7,
            ];
        @endphp

        @foreach ( $newSpecsTable as $min => $max )
            <div class="flex flex-col items-center justify-center ">
                <x-specstable2 :fifth="4" :min=$min  :max=$max />
            </div>
        @endforeach

        <div class="flex flex-col">
            <div class="flex items-end">
                <x-confirmseries/>
            </div>
        </div>
        </form>

    </div>

        @endif


        <x-handler process="{{ session('process') }}" compare="Model" compareErr="model already exist"/>






    </div>









</body>
</html>





{{--@dump(session()->all())--}}
