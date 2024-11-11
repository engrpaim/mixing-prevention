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


    <div class="flex flex-col self-center w-screen m-auto mt-24 rounded-lg shadow-md shadow-gray-300 min-w-fit max-w-fit min-h-auto">
        <div   div class="flex justify-center w-full py-4 bg-blue-200 min-w-fit">
            <h1 class="font-bold">ADD: MODEL DETAILS</h1>
        </div>
        <div class="flex flex-col flex-wrap p-5 font-semibold w-96 min-w-fit">

                <form name="add-model-form" id="add-model-form" method="POST" action="{{ url('add-model-data') }}">
                    @csrf
                    {{-- MODEL INFO--}}
                    <div class="flex flex-row mx-2 ">
                        <div class="flex flex-row mr-10">
                            <div class="flex-col mx-5 mt-3 min-w-fit">
                                <label for="model_name" required>Model name:</label>
                            </div>
                            <div class="flex flex-row">
                                <input class="p-3 mx-2 rounded-lg shadow-lg max-h-fit outline outline-1 outline-gray-300 hover:bg-blue-100 hover:outline-blue-500 hover:outline-2" name="model_name" id="model_name" placeholder="add model here" required>
                            </div>
                        </div>

                        <x-selectdropdown column="process" show="YES" title="PROCESS FLOW" :array="$allModel" />

                    </div>

                    <script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>

                </form>




            <form name="specs-model-form" id="specs-model-form" method="POST" action="{{ url('specs-model-data') }}" class="max-min-fit ">
                @csrf
                <input type="hidden" name="selected_processes2" id="selected_processes2">
                <input type="hidden" name="model_name2" id="model_name2">

                <x-submit-button type="button" onclick="addSpecs()" style="block;" name="update" id="add_specs_btn">Add specs</x-submit-button>

                <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
                <script type="text/javascript" src="{{ asset('js/processFlow.js') }}"></script>
            </form>


        </div>
        @if (session('processedData'))
        <script text="text/javascript" src="{{ asset('js/hide.js') }}">
        </script>
        <divs class="flex flex-col items-center justify-center ">

            <form name="add-specs-form" id="add-specs-form" method="POST" action="{{ url('add-specs-data') }}" >
                @csrf
                <div class="flex flex-row items-center justify-center">
                    <div class="flex flex-row justify-between mx-10">
                        <div class="flex flex-col h-10 p-2 m-20 shadow-lg min-w-80 max-w-fit rounded-xl outline outline-1 outline-slate-200">
                            <div  class="flex flex-row items-center justify-center">
                                <span >Model:&nbsp;&nbsp;</span>
                                <span >{{ session('modelName') }}</span>
                                <input type="hidden" name="add_model" id="add_model" value={{ session('modelName')  }}/>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row p-2 m-10 bg-red-200 min-h-fit w-80 min-w-fit rounded-xl outline outline-2 outline-red-500">
                        <div  class="flex flex-row items-center p-4 m-3">
                            <span name="message_info" id="message_info" class="text-center"><i><strong>Attention:</strong> Please verify all specification for more<br>accurate comparison</i></span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <x-specstable :fourth="3" />
                </div>


                <div class="flex flex-col">
                    <x-specstable2 :fifth="3"/>
                </div>





                <div>
                    <x-confirmseries/>
                </div>





        </div>



        @endif




    </form>
    </div>










</body>
</html>
