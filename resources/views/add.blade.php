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


    <div class="flex flex-col self-center w-screen m-auto mt-24 rounded-lg shadow-md shadow-gray-300 min-w-fit max-w-fit">
        <div   div class="flex justify-center py-4 bg-blue-200 min-w-fit">
            <h1 class="font-bold">ADD: MODEL DETAILS</h1>
        </div>
        <div class="flex flex-col flex-wrap p-5 font-semibold w-96 min-w-fit">

                <form name="add-model-form" id="add-model-form" method="POST" action="{{ url('add-model-data') }}">
                    @csrf
                    {{-- MODEL INFO--}}
                    <div class="flex flex-row mx-2 ">
                        <div class="flex flex-row mr-10">
                            <div class="flex-col mx-5 mt-3 min-w-fit">
                                <label for="model_name" required>MODEL NAME:</label>
                            </div>
                            <div class="flex flex-row">
                                <input class="p-3 mx-2 rounded-lg shadow-lg max-h-fit outline outline-1 outline-gray-300 hover:bg-blue-100 hover:outline-blue-500 hover:outline-2" name="model_name" id="model_name" placeholder="add model here" required>
                            </div>
                        </div>

                        <x-selectdropdown column="process" show="YES" title="PROCESS FLOW" :array="$allModel" />

                    </div>

                    <script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>

                </form>




            <form name="specs-model-form" id="specs-model-form" method="POST" action="{{ url('specs-model-data') }}" class="flex flex-col">
                @csrf
                <input type="hidden" name="selected_processes2" id="selected_processes2">

                <x-submit-button type="button" onclick="addSpecs()" style="block;" name="update" id="add_specs_btn">Add specs</x-submit-button>
                @if (session('processedData'))
                    <script> //add-model-form
                             document.getElementById('add_specs_btn').style.display ='none';
                             document.getElementById('add-model-form').style.display ='none';
                    </script>
                    <div class="flex flex-row">
                    @foreach (session('processedData') as $data)
                        @foreach ($data as $key => $value )
                            @php

                            //@dump($key);
                            $processNumber= explode('_',$key);
                            $processNumber = (int)$processNumber[1]+1;
                            //@dump($processNumber[1]);
                            @endphp

                            <div class="flex-row p-3 m-2 rounded-lg shadow-lg w-96 h-fit min-h-fit outline-zinc-200 outline outline-1">
                                <div class="flex flex-col items-center">
                                    <div class="flex flex-col m-2">
                                        <span>PROCESS {{ $processNumber }} </span>

                                        </div>
                                    <div class="flex flex-col self-start min-w-full p-2 rounded-md shadow-lg bg-violet-200">
                                        <span>{{ $value }} </span>
                                        </div>
                                </div>
                                <div>

                                </div>
                            </div>



                        @endforeach
                    @endforeach
                    </div>

                        {{-- BUTTONS --}}
                      <div class="flex flex-col mt-10 mr-64 justify-self-start">

                        <x-handler process="{{ session('process') }}" compare="Model" compareErr="model already exist"/>

                        <x-submit-button type="button" onclick="addModel()" style="block;" name="add" id="add_model_btn">Add model</x-submit-button>

                        <div id="confirm_details" style="display: none;">

                            <p>Are you sure you want to add model?</p>
                            <div  id="model_summary"></div>

                            <x-submit-button type="button" onclick="confirmAdd()" style="block;" name="confirm" id="confirm">CONFIRM</x-submit-button>

                            <x-submit-button type="button" onclick="cancelAdd()" style="block;" name="cancel" id="cancel">CANCEL</x-submit-button>

                        </div>
                    </div>

                @endif
                <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
                <script type="text/javascript" src="{{ asset('js/processFlow.js') }}"></script>
            </form>

        </div>

    </div>



    @php
        @dump(session()->all())
    @endphp







</body>
</html>
