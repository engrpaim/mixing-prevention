<div class="flex flex-row m-3 mx-4 min-h-fit min-w-fit">
    <div class="flex flex-col mx-2 mt-3 min-w-fit">
        <label for="{{ $column }}">{{ $label }}</label>
    </div>
    <div class="flex flex-row">
        <select name="{{ $column }}" id="{{ $column }}" class="p-3 ml-2 rounded-lg shadow-lg max-h-fit min-w-fit outline outline-1 outline-gray-300 hover:bg-blue-100 hover:outline-blue-500 hover:outline-2" required>
            @if(count($array ) <= 0){
                <option  value=""   disabled selected>No data found</option>
            }
            @else
                <option  value=""   disabled selected></option>
                @foreach ($array as $tableColumn)
                    <option value="{{ $tableColumn->$column }}">{{ $tableColumn->$column }}</option>
                @endforeach
            @endif



        </select>
    </div>
    @if ($show == 'YES')
        <div class="flex flex-row ">
            <div  class="mb-1 ml-5 shadow-xl bg-slate-50 outline outline-1 outline-gray-100 w-72 h-96 rounded-xl min-w-fit min-h-fit ">
                <h1 class="flex justify-center p-2 text-xs min-w-fit">{{ $title }}</h1>
                <div id="span-container" class="flex flex-col max-w-full mx-3 "></div><br>
                <input type="hidden" name="selected_processes" id="selected_processes">
            </div>
        </div>
    @endif

</div>


