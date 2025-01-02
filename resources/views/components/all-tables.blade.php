
<div class="relative flex flex-col items-center">

    <div class="flex flex-row self-start mt-2 ">
        <h1 class="font-bold">MANAGE INFORMATION</h1>
    </div>
    <div class="flex self-start w-full p-1 m-1 text-base bg-blue-300 rounded-lg max-sm:flex-col">
        <div class="flex flex-row m-2">
            <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="#5f6368"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" fill="currentColor"/></svg>
            <h3><i>&nbsp;ADD DATA</i></h3>
        </div>
    </div>
    <div class="flex flex-row mx-0 mt-1 max-md:flex-col ">

    {{-- SIDE FORMS PROCESS ADD  --}}
    <div class="flex max-md:flex-col bg-blue ">
    @php
    $forms = [
        [
            'formName' => 'add_process_form',
            'action' => 'add-process-data',
            'show' => 'PROCESS:',
            'placeholder' => 'add process here',
            'inputId' => 'add_process',
            'inputName' => 'add_process',
            'btnName' => 'btnProcess',
            'btnLabel' => 'process',
            'compare' => 'Process',
            'compareErr' => 'process already exist',
            'buttonOnclick' => 'processAdd()'
        ],
        [
            'formName' => 'before_material_form',
            'action' => 'before-material-data',
            'show' => 'MATERIAL(BEFORE):',
            'placeholder' => 'add before material here',
            'inputId' => 'before_material',
            'inputName' => 'before_material',
            'btnName' => 'btnBefore',
            'btnLabel' => 'before material',
            'compare' => 'Before Material',
            'compareErr' => 'material(before) already exist',
            'buttonOnclick' => ''
        ],
        [
            'formName' => 'after_material_form',
            'action' => 'after-material-data',
            'show' => 'MATERIAL(AFTER):',
            'placeholder' => 'add after material here',
            'inputId' => 'after_material',
            'inputName' => 'after_material',
            'btnName' => 'btnAfter',
            'btnLabel' => 'after material',
            'compare' => 'After Material',
            'compareErr' => 'after(material) already exist',
            'buttonOnclick' => ''
        ],
        [
            'formName' => 'finish_form',
            'action' => 'finish-data',
            'show' => 'FINISH:',
            'placeholder' => 'add finish here',
            'inputId' => 'finish_details',
            'inputName' => 'finish_details',
            'btnName' => 'btnFinish',
            'btnLabel' => 'finish',
            'compare' => 'Finish',
            'compareErr' => 'finish already exist',
            'buttonOnclick' => ''
        ],
        [
            'formName' => 'type_form',
            'action' => 'type-data',
            'show' => 'TYPE:',
            'placeholder' => 'add type here',
            'inputId' => 'type_details',
            'inputName' => 'type_details',
            'btnName' => 'btnType',
            'btnLabel' => 'type',
            'compare' => 'Type',
            'compareErr' => 'type already exist',
            'buttonOnclick' => ''
        ],

    ];
    @endphp

    @foreach ($forms as $form)
        <div class="flex flex-col">
            <x-form formName="{{ $form['formName'] }}" formId="{{ $form['formName'] }}" method="POST" action="{{ $form['action'] }}"
                name="{{ strtolower($form['formName']) }}" show="{{ $form['show'] }}" placeholder="{{ $form['placeholder'] }}"
                inputeId="{{ $form['inputId'] }}" inputName="{{ $form['inputName'] }}" buttonType="submit"
                buttonOnclick="{{ $form['buttonOnclick'] }}" style="block;" btnName="{{ $form['btnName'] }}"
                btnId="{{ $form['btnName'] }}" btnLabel="{{ $form['btnLabel'] }}"/>

            <x-handler process="{{ session('process') }}" compare="{{ $form['compare'] }}" compareErr="{{ $form['compareErr'] }}"/>
        </div>
    @endforeach


    </div>
    </div>
    {{-- SIDE FORMS PROCESS UPDATE/MATERIAL UPDATE  --}}

    @php
        $table = [
            []
        ];
    @endphp
    <div class="absolute flex w-full pr-10 bg-blue-300 rounded-lg mt-72 max-sm:flex-col ">
        <div class="flex flex-row p-2 ">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840q82 0 155.5 35T760-706v-94h80v240H600v-80h110q-41-56-101-88t-129-32q-117 0-198.5 81.5T200-480q0 117 81.5 198.5T480-200q105 0 183.5-68T756-440h82q-15 137-117.5 228.5T480-120Zm112-192L440-464v-216h80v184l128 128-56 56Z" fill="currentColor"/></svg>
            <h3 ><i>&nbsp;UPDATE/DELETE DATA</i></h3>
        </div>
    </div>
    <div class="flex flex-col items-center justify-center max-sm:relative md:absolute mt-80 sm:flex-row updateTables max-md:flex-col max-md:items-center minw-w-fit">

        <div class="flex my-4">
            @php
                $allTablesComponents =[
                    [
                        'title' => 'PROCESS',
                        'array' => $allProcess,
                        'column' => 'process',
                        'compare' => 'Process',
                    ],
                    [
                        'title' => 'BEFORE-MATERIAL',
                        'array' => $allBeforeMaterial,
                        'column' => 'before_material',
                        'compare' => 'Before',
                    ],
                    [
                        'title' => 'AFTER-MATERIAL',
                        'array' => $allAfterMaterial,
                        'column' => 'after_material',
                        'compare' => 'After',
                    ],
                    [
                        'title' => 'FINISH',
                        'array' => $allFinish,
                        'column' => 'finish',
                        'compare' => 'Finish',
                    ],
                    [
                        'title' => 'TYPE',
                        'array' => $allType,
                        'column' => 'type',
                        'compare' => 'type',
                    ],


                ];
            @endphp

            @foreach ($allTablesComponents as $tablesData)
                <x-table title="{{ $tablesData['title'] }}" :array="$tablesData['array']" column="{{ $tablesData['column']  }}" compare="{{ $tablesData['compare']  }}" />
            @endforeach


        </div>





    </div>

</div>

