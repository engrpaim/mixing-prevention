<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0" >
        <meta http-equiv="X-UA-Compatible" content="ie=edge" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>Mixing: Add</title>
    </head>
    <body>
        @include('components.all-nav')
        @php
            function convertSpecial($tableName){
                $remove_special= preg_replace('/[^\w\s]/', '%', $tableName);
                $remove_special = str_replace('_', '%', $remove_special);
                return strtolower($remove_special);
            }
        @endphp
        <div class="flex flex-col items-center justify-center ">
            <div class="flex my-10 ">
                <form name="range_form" id="range_form" method="POST" action="{{ url('range-data') }}" >
                    @csrf
                    {{-- Range slector --}}
                  <x-showrange :array="$isDisplayCheckBox" :before="$displayInSelectbeforeMaterial" :after="$displayInSelectafterMaterial"/>
                </form>
            </div>
            <div class="flex flex-col ">
            @if ( isset($buttonModels) && !empty($buttonModels) || isset($AllCommonMaterials) && !empty($AllCommonMaterials))
                @if (!empty($AllCommonMaterials))

                    <div class="flex flex-col items-center justify-center min-h-full">
                        <div class="flex-grow">
                            <table id="material-table" class="w-screen my-5 table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th  class="px-4 py-2 text-center border border-gray-300">MODEL&nbsp;NAME</th>
                                        <th  class="px-4 py-2 text-center border border-gray-300">MATERIALS COMMON</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="pagination-mats" class="mb-10"></div>
                    </div>
                    <script>
                        const common_material = @json($AllCommonMaterials);
                        let all_material_array = [];

                        const rowsPerMaterial = 10;
                        let materialCurrentPage = 1;


                        let totalMaterial = Math.ceil(all_material_array.length / rowsPerMaterial);

                        function materialtable(){
                            const MaterialBody = document.querySelector('#material-table tbody');
                            const materialPagination = document.querySelector('#pagination-mats');
                            MaterialBody.innerHTML = '';

                            all_material_array = [];

                            for (let materialKey in common_material.after) {
                                let after = common_material['after'][materialKey];
                                all_material_array.push({ [materialKey]: { after: after } });
                            }

                            for (let materialKey in common_material.before) {
                                let before = common_material['before'][materialKey];
                                let isExistInArray = all_material_array.find(item => item[materialKey]);
                                if (isExistInArray) {
                                    isExistInArray[materialKey].before = before;
                                } else {
                                    all_material_array.push({ [materialKey]: { before: before } });
                                }
                            }

                            totalMaterial = Math.ceil(all_material_array.length / rowsPerMaterial);


                            const matStart = (materialCurrentPage - 1) * rowsPerMaterial;
                            const matEnd = materialCurrentPage * rowsPerMaterial;
                            const matcurrentData = all_material_array.slice(matStart, matEnd);

                            matcurrentData.forEach(function(data) {
                                const materialRow = document.createElement('tr');
                                let materialData = '';
                                let model = '';
                                for (let key in data) {

                                    if (data[key].before) {
                                        materialData += "<button class='p-2 m-2 text-xs font-bold text-yellow-700 bg-yellow-100 rounded outline outline-2 outline-yellow-500'>BEFORE: " + data[key].before + "</button>";
                                    }

                                    if (data[key].after) {
                                        materialData += "<button class='p-2 m-2 text-xs font-bold text-blue-700 bg-blue-100 rounded outline outline-2 outline-blue-500'>AFTER: " + data[key].after + "</button>";
                                    }

                                    model = "<td class='px-4 py-2 text-left border border-gray-300 W-92 max-W-92 '>" + key + "</td>";
                                }

                                let combineMaterialData = model + "<td class='px-4 py-2 text-left border border-gray-300'>" + materialData + "</td>";
                                materialRow.innerHTML = combineMaterialData;
                                MaterialBody.appendChild(materialRow);
                            });

                            matUpdatePagination();
                        }

                        function matUpdatePagination() {
                            const pagination = document.querySelector('#pagination-mats');
                            pagination.innerHTML = '';

                            const prevButton = document.createElement('button');
                            prevButton.innerText = 'Previous';
                            prevButton.classList.add('p-2', 'm-1', 'text-xs', 'font-bold', 'text-gray-700', 'bg-gray-100', 'rounded', 'outline', 'outline-2', 'outline-gray-500');
                            prevButton.disabled = materialCurrentPage === 1;
                            prevButton.addEventListener('click', function () {
                                if (materialCurrentPage > 1) {
                                    materialCurrentPage--;
                                    materialtable(); a
                                }
                            });
                            pagination.appendChild(prevButton);


                            for (let i = 1; i <= totalMaterial; i++) {
                                const pageButton = document.createElement('button');
                                pageButton.innerText = i;
                                pageButton.classList.add('p-2', 'm-1', 'text-xs', 'font-bold', 'text-gray-700', 'bg-gray-100', 'rounded', 'outline', 'outline-2', 'outline-gray-500');
                                pageButton.disabled = i === materialCurrentPage;
                                pageButton.addEventListener('click', function () {
                                    materialCurrentPage = i;
                                    materialtable();
                                });
                                pagination.appendChild(pageButton);
                            }


                            const nextButton = document.createElement('button');
                            nextButton.innerText = 'Next';
                            nextButton.classList.add('p-2', 'm-1', 'text-xs', 'font-bold', 'text-gray-700', 'bg-gray-100', 'rounded', 'outline', 'outline-2', 'outline-gray-500');
                            nextButton.disabled = materialCurrentPage === totalMaterial;
                            nextButton.addEventListener('click', function () {
                                if (materialCurrentPage < totalMaterial) {
                                    materialCurrentPage++;
                                    materialtable();
                                }
                            });
                            pagination.appendChild(nextButton);
                        }


                        materialtable();
                    </script>

                @endif

                @if (!empty($buttonModels))
                    <div class="flex flex-col items-center justify-center min-h-full">
                        <div class="flex-grow">
                            <table id="dimension-table" class="w-screen my-5 table-auto min-w-screen max-w-screen ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th  class="px-4 py-2 text-center border border-gray-300">MODEL&nbsp;NAME</th>
                                        <th class="px-4 py-2 text-center border border-gray-300">DIMENSION PROCESS COMMON</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="pagination" class="mb-10"></div>
                    </div>
                    <script>
                        const data = @json($buttonModels);
                        const values = @json($allDimensionsValue );

                        const rowsPerPage = 10;
                        let currentPage = 1;
                        let totalPages = Math.ceil(data.length / rowsPerPage);

                        // console.log(data);
                        // console.log(values);

                        let all_processes = [];

                        function tableData(){

                            const tableBody =document.querySelector('#dimension-table tbody');
                            const pagination = document.querySelector('#pagination');
                            tableBody.innerHTML = '';

                            const start = (currentPage - 1) * rowsPerPage;
                            const end = currentPage * rowsPerPage;
                            const currentData = data.slice(start, end);

                            all_processes = [];
                            for(let key in values){
                                all_processes.push(key);
                            }


                            const count_process = all_processes.length;
                            currentData.forEach(function(perModel){
                                const row = document.createElement('tr');

                                let tableDataPerRow = '';
                                for(let i = 0 ; i < count_process ; i++){

                                    if(values[all_processes[i]][perModel]){

                                        let dataSpecs = all_processes[i].replace("%", " ") + ": "+values[all_processes[i]][perModel];
                                        tableDataPerRow = tableDataPerRow + "<button class='p-2 m-2 text-xs font-bold text-gray-700 bg-gray-100 rounded outline outline-2 outline-gray-500'>"+dataSpecs+"</button>";

                                    }

                                }

                                const rowModel = "<td class='px-4 py-2 text-left border border-gray-300 w-60'>"+perModel+"</td>";
                                const oneSpecsRowData = "<td class='px-4 py-2 text-left border border-gray-300'>"+tableDataPerRow+"</td>"
                                row.innerHTML = rowModel + oneSpecsRowData;

                                tableBody.appendChild(row);

                            });




                            updatePagination();
                        }

                        function updatePagination() {
                            const pagination = document.querySelector('#pagination');
                            pagination.innerHTML = '';

                            const prevButton = document.createElement('button');
                            prevButton.innerText = 'Previous';
                            prevButton.classList.add('p-2', 'm-1', 'text-xs', 'font-bold', 'text-gray-700', 'bg-gray-100', 'rounded', 'outline', 'outline-2', 'outline-gray-500');
                            prevButton.disabled = currentPage === 1;
                            prevButton.addEventListener('click', function () {
                                if (currentPage > 1) {
                                    currentPage--;
                                    tableData();
                                }
                            });
                            pagination.appendChild(prevButton);

                            for (let i = 1; i <= totalPages; i++) {
                                const pageButton = document.createElement('button');
                                pageButton.innerText = i;
                                pageButton.classList.add('p-2', 'm-1', 'text-xs', 'font-bold', 'text-gray-700', 'bg-gray-100', 'rounded', 'outline', 'outline-2', 'outline-gray-500');
                                pageButton.disabled = i === currentPage;
                                pageButton.addEventListener('click', function () {
                                    currentPage = i;
                                    tableData();
                                });
                                pagination.appendChild(pageButton);
                            }



                            const nextButton = document.createElement('button');
                                nextButton.innerText = 'Next';
                                nextButton.classList.add('p-2', 'm-1', 'text-xs', 'font-bold', 'text-gray-700', 'bg-gray-100', 'rounded', 'outline', 'outline-2', 'outline-gray-500');
                                nextButton.disabled = currentPage === totalPages;
                                nextButton.addEventListener('click', function () {
                                    if (currentPage < totalPages) {
                                        currentPage++;
                                        tableData();
                                    }
                                });
                                pagination.appendChild(nextButton);

                        }
                        tableData();


                    </script>
                @endif



            @elseif(isset($isDisplayAllmodell) && !empty($isDisplayAllmodell))
                <div class="flex flex-col items-center justify-center text-xs">
                    <div class="flex flex-col">
                        <div class="flex items-end justify-end">
                            <input type="text" class="flex items endjustify-end p-2 mx-0.5  outline outline-blue-600 w-28 "name="search" id="search" placeholder="Search ...." />
                        </div>

                        <table class="bg-blue-50 w-screen2" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-blue-200 border border-blue-600">MODEL</th>
                                    <th class="px-4 py-2 text-left bg-blue-200 border border-blue-600">PROCESS FLOW</th>
                                </tr>
                            </thead>
                            <tbody id="data.table_data">
                                <tr>
                                  @foreach($isDisplayAllmodell as $model)
                                    <tr>
                                        <td class="px-4 py-2 text-left border border-blue-500">{{ $model->model }}</td>
                                        <td class="px-4 py-2 text-left border border-blue-500">

                                                @php
                                                    $displayALLExplode =explode(";",$model->process_flow);
                                                    $colors = ["green" , "violet","red","blue","yellow","pink"];
                                                    $colorsCounter = 0;
                                                @endphp

                                                @foreach ( $displayALLExplode  as $showButton2 )
                                                    @if($showButton2 != '')

                                                        <button
                                                            type="button"
                                                            onclick="changeUrl('{{ $model->model }}', '{{ convertSpecial($showButton2) }}')"
                                                            id="{{ $model->model  }}_{{ $showButton2  }}"
                                                            class="p-2 my-2 mx-1 text-xs font-bold text-{{ $colors[$colorsCounter] }}-700 bg-{{  $colors[$colorsCounter] }}-100 rounded outline outline-2 outline-{{  $colors[$colorsCounter] }}-500">
                                                                {{ $showButton2 }}
                                                        </button>
                                                        @php
                                                            $colorsCounter++;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                        </td>
                                    </tr>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex my-10 " id="paginationControls">
                        {{ $isDisplayAllmodell->links() }}
                    </div>
                </div>


                <script>
                $(document).ready(function () {

                    $(document).on('keyup', '#search', function () {
                        var query = $(this).val();

                        if (query.trim() === "") {
                            location.reload();
                            return;
                        }

                        $.ajax({
                            url: "{{ route('ViewList.CheckBoxProcess') }}",
                            method: 'GET',
                            data: { query: query },
                            dataType: 'json',
                            success: function (data) {
                                $('tbody').html(data.table_data);
                            }

                        });
                    });
                });

                </script>
            @else
                <div class="flex flex-col p-5 my-10 text-red-600 bg-red-100 rounded-lg w-screen2 outline outline-red-500">
                    <div class="flex items-center justify-center italic font-bold">
                        <div class="flex mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="currentColor"><path d="M479.99-280q15.01 0 25.18-10.15 10.16-10.16 10.16-25.17 0-15.01-10.15-25.18-10.16-10.17-25.17-10.17-15.01 0-25.18 10.16-10.16 10.15-10.16 25.17 0 15.01 10.15 25.17Q464.98-280 479.99-280Zm-31.32-155.33h66.66V-684h-66.66v248.67ZM480.18-80q-82.83 0-155.67-31.5-72.84-31.5-127.18-85.83Q143-251.67 111.5-324.56T80-480.33q0-82.88 31.5-155.78Q143-709 197.33-763q54.34-54 127.23-85.5T480.33-880q82.88 0 155.78 31.5Q709-817 763-763t85.5 127Q880-563 880-480.18q0 82.83-31.5 155.67Q817-251.67 763-197.46q-54 54.21-127 85.84Q563-80 480.18-80Zm.15-66.67q139 0 236-97.33t97-236.33q0-139-96.87-236-96.88-97-236.46-97-138.67 0-236 96.87-97.33 96.88-97.33 236.46 0 138.67 97.33 236 97.33 97.33 236.33 97.33ZM480-480Z"/></svg>
                        </div>
                        <div>
                            <h1>No data found</h1>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-start px-6 mt-10 text-gray-700 md:px-20">

                        <div class="space-y-4 text-lg">
                            <p class="text-base leading-6">
                                <span class="text-primary-600">•</span> <strong class="italic font-semibold">No model within the range.</strong>
                            </p>
                            <p class="text-base leading-6">
                                <span class="text-primary-600">•</span> Input <strong class="font-semibold">target</strong> value (max & min are not required).
                            </p>
                            <p class="text-base leading-6">
                                <span class="text-primary-600">•</span> Select <strong class="font-semibold">process</strong> where dimensions will be checked.
                            </p>
                        </div>


                        <div class="my-6">
                            <hr class="border-t-2 border-gray-300" />
                        </div>


                        <div class="space-y-4">
                            <p class="italic font-semibold">
                                <i>If all procedures have already been tried, please contact us.</i>
                            </p>
                            <div>
                                <p class="text-sm">Local: <span class="font-bold">619</span></p>
                                <p class="text-sm">Email: <a href="mailto:automation@smp.com.ph" class="text-blue-600">automation@smp.com.ph</a>, <a href="mailto:automation@smp.com.ph" class="text-blue-600">automation@smp.com.ph</a></p>
                            </div>
                        </div>
                    </div>


                </div>

            @endif
            </div>
            @if (session('viewlistSpecs'))
                <div id="showData" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

                    <div id="detailsShow" class="flex flex-col items-center p-10 bg-blue-200 rounded-2xl w-fit h-fit">
                        <div class="flex items-end justify-end w-full ">
                            <button type="button" onclick="hideViewListShow()"class="font-bold text-red-600 font-xl">x</button>
                        </div>

                        @foreach ( session('viewlistSpecs') as $keyData => $data )
                            @foreach ($data  as $specsKey => $specsValue )
                                <div class="flex flex-col font-bold ">

                                    <div class="flex flex-col items-center justify-center mb-2">
                                        <h1 id="table">{{ strtoupper(str_replace("%"," ",$keyData))  }}</h1>
                                        <h3 id="model" class="font-normal">{{$specsValue->model}}</h3>
                                    </div>

                                    @php
                                        $specifications = ['length_val','width_val','thickness_val','ir_val','or_val','a_val'];
                                    @endphp
                                    <form name="edit_viewlist" id="edit_viewlist" method="POST" action="{{ url('edit-viewlist-data') }}">
                                        @csrf
                                        <input type="hidden" name="tableFind" id="tableFind" value="{{ $keyData }}"/>
                                        <input type="hidden" name="model" id="model" value="{{ $specsValue->model }}"/>
                                        @foreach ($specifications as $dataSpecs)
                                            @if (property_exists($specsValue,$dataSpecs) && $specsValue->$dataSpecs > 0)
                                                @php
                                                    $specsDisplay = explode("_",$dataSpecs);
                                                    $specsMin = $specsDisplay[0]."_min";
                                                    $specsMax = $specsDisplay[0]."_max";
                                                @endphp
                                                <div class="flex flex-row justify-between w-full p-1">
                                                    <div class="flex items-start mr-5">
                                                        <label class="font-normal">{{ strtoupper($specsDisplay[0]) }}</label>
                                                    </div>
                                                    <div class="flex items-end inputs-container">
                                                            @php
                                                                $styleinput = "p-1 mx-1 text-center bg-blue-100 rounded-md focus:bg-yellow-100 focus:outline-blue-600";
                                                            @endphp
                                                            <input  id="{{ $specsDisplay[0] }}_val"  name="{{ $specsDisplay[0] }}_val"  class="{{  $styleinput }}" value="{{  $specsValue->$dataSpecs }}" disabled>
                                                            <label class="mx-1 ml-2 font-normal">MIN</label>
                                                            <input id="{{ $specsDisplay[0] }}_min" name="{{ $specsDisplay[0] }}_min" class="{{  $styleinput }}" value="{{  $specsValue->$specsMin }}" disabled>
                                                            <label class="mx-1 font-normal">MAX</label>
                                                            <input  id="{{ $specsDisplay[0] }}_max" name="{{ $specsDisplay[0] }}_max" class="{{  $styleinput }}" value="{{  $specsValue->$specsMax }}"disabled>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach

                                        <div class="flex justify-end text-base font-normal text-white">
                                            <div id="btnDiv" class="flex flex-row my-10 bg-blue-400 rounded-lg hover:bg-blue-600 w-fit">
                                                <button  onclick="hideThis()" type="button"  id="edit-button" class="m-2" >Edit</button>
                                                <div class="flex items-center justify-center mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="save" style="display:none;">
                                            <div  class="flex justify-end text-base font-normal text-white">

                                                <div   class="flex flex-row justify-center my-10 bg-red-400 rounded-lg w-fit hover:bg-red-600">
                                                    <button  onclick="hideThis()" type="submit" class="m-2" >Save</button>
                                                    <div class="flex items-center justify-center mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160Zm-80 34L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Zm-40-86v446-560 114Z"/></svg>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <script>
                                        const editButton = document.getElementById('edit-button');
                                        const inputFields = document.querySelectorAll('.inputs-container input');

                                        editButton.addEventListener('click', () => {

                                            inputFields.forEach(input => {
                                                input.removeAttribute('disabled');
                                            });
                                        });
                                    </script>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <script>
            function changeUrl(model, processFlow) {
                var encodedModel = encodeURIComponent(model);
                var encodedProcessFlow = encodeURIComponent(processFlow);
                var newUrl = '/viewlist/details/' + encodedModel + '/' + encodedProcessFlow;
                window.location.href = newUrl;
            }

            function hideViewListShow(){
                var model = document.getElementById('model').innerHTML;
                document.getElementById('search').value = model;
                var containerViewListShow = document.getElementById('showData').style.display ="none";
                $('#search').trigger('keyup');
                console.log(search, model);

            }



            function hideThis(){
                var editHide = document.getElementById('btnDiv').style.display = "none";
                var saveShow = document.getElementById('save').style.display = "block";
                var detailsShow = document.getElementById('detailsShow').style.backgroundColor = "#ffc2bc";
                var table = document.getElementById('table').innerHTML;
                var model = document.getElementById('model').innerHTML;
                console.log(table, model);
            }
        </script>
    <x-footer/>

    </body>
</html>





{{--
@dump(get_defined_vars())
@dump(session()->all()) --}}
