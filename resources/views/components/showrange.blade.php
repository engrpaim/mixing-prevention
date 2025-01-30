@php
    $defaultValue = ['length','width','thickness','outer radius','inner radius','a'];
@endphp

<div class="flex flex-row items-center justify-center px-8 py-2 rounded-lg bg-violet-200 outline outline-2 outline-violet-600" >

    <div class="flex flex-col items-center justify-between w-42 ">
        <div class="text-2xl font-bold text-violet-900">
            <h1>MATERIAL</h1>
        </div>
        <div class="flex flex-row items-center my-2">
            <h1 class="mx-2 font-semibold text-violet-900">AFTER</h1>
            <select id="after_mats"  name="after_mats"  class="p-2 mx-1 my-5 text-sm rounded-lg text-violet-900 focus:outline-violet-600 focus:bg-blue-50" required>
                <option  value=" " disabled selected></option>
                @foreach ( $after as $after_mats)
                    <option  value="{{ $after_mats->after_material }}">{{ $after_mats->after_material }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-row items-center">
            <h1 class="mx-2 font-semibold text-violet-900">BEFORE</h1>

            <select id="before_mats" name="before_mats"  class="p-2 mx-1 my-5 text-sm rounded-lg text-violet-900 focus:outline-violet-600 focus:bg-blue-50" >
                <option  value=" " disabled selected></option>
                @foreach ( $before as $before_mats)
                    <option  value="{{ $before_mats->before_material }}">{{ $before_mats->before_material }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="flex flex-col items-center justify-between w-full">
        <div class="text-2xl font-bold text-violet-900">
            <h1>RANGE</h1>
        </div>
        @foreach ($defaultValue as $createInputRange )
        <div class="flex flex-col items-center justify-between w-full gap-4 p-2 my-1 text-xs text-violet-900">
            <div class="flex flex-col">
                <div class="flex flex-row">
                    <div class="flex justify-between px-1 w-60 bg-violet-100">
                        <label class="p-2 font-bold" for="{{ $createInputRange }}">TARGET&nbsp;{{ strtoupper($createInputRange) }}</label>
                        <input class="w-20 p-2 text-center rounded-lg outline outline-2 outline-violet-300 hover:bg-red-50 focus:bg-red-50 "type="number" step="0.001" id="{{ $createInputRange }}" name="{{ $createInputRange }}" />
                    </div>

                    <div class="flex px-3 rounded-lg bg-violet-800">
                        <label class="p-2 font-bold text-white" for="{{ $createInputRange }}_max">MAX:&nbsp;</label>
                        <input class="w-20 p-2 text-center rounded-lg outline outline-2 outline-violet-300 hover:bg-red-50 focus:bg-red-50 "type="number" step="0.001" id="{{ $createInputRange }}_max" name="{{ $createInputRange }}_max" />

                        <label class="p-2 font-bold text-white" for="{{ $createInputRange }}_min">MIN:&nbsp;</label>
                        <input class="w-20 p-2 text-center rounded-lg outline outline-2 outline-violet-300 hover:bg-red-50 focus:bg-red-50 "type="number" step="0.001" id="{{ $createInputRange }}_min" name="{{ $createInputRange }}_min" />
                    </div>

                </div>

            </div>
        </div>
        @endforeach





    </div>
    <div class="flex flex-col">

        @php
            $countCheckBox = 0;
        @endphp

        @foreach ($array as $processCheckBox)
            <div class="flex flex-row">
                <input type="checkbox" name="{{ $processCheckBox->specification }}_checkBox" id="{{ $processCheckBox->specification }}_checkBox" value="{{ $processCheckBox->processes  }}">
                <label for="{{ $processCheckBox->process }}__checkBox">{{ $processCheckBox->specification }}</label>
            </div>
        @endforeach
        <button type="submit" id="findBtn" name="findBtn" class="px-2 py-1 m-2 mt-20 text-sm font-bold text-yellow-800 bg-yellow-200 rounded-lg outline outline-2 outline-yellow-600 " value="find" >FIND</button>
        @if ($view == 'ON' || $admin == 'ON')
        <button type="button" id="viewBtn" name="viewBtn" onclick="viewAll()" class="px-2 py-1 m-2 mt-5 text-sm font-bold text-green-800 bg-green-200 rounded-lg outline outline-2 outline-green-600 "value="view">VIEW ALL</button>

        @endif
        <script>
            function viewAll(){
                window.location.replace('/list');
            }
        </script>
    </div>

</div>

