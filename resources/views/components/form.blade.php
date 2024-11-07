<div class="p-2 rounded w-96 min-h-fit hover:bg-yellow-100 min-w-fit md:m-4 max-h-28 outline outline-1 outline-gray-300">
    <form class="flex flex-col items-center p-3 max-md:p-5" name="{{ $formName }}" id="{{ $formId }}" method="{{ $method }}" action="{{ url($action) }}" >
        @csrf
        <div>
        <label for="{{ $name }}">{{ $show }}</label>
        <input class="p-1 rounded outline outline-1 outline-gray-300 hover:outline-blue-600 hover:outline-2 hover:bg-blue-200"  type="text" placeholder="{{ $placeholder }}" id="{{ $inputeId }}" name="{{ $inputName }}" required/>
        </div>
        <button class="p-2 m-4 font-sans text-gray-600 bg-blue-100 rounded-md hover:text-blue-700 hover:font-bold hover:outline-2 hover:outline-blue-400 outline outline-1 outline-gray-100 hover:shadow-lg hover:bg-blue-300" type="{{ $buttonType }}" onclick="{{ $buttonOnclick }}" style="display: {{ $style }}" name="{{ $btnName }}" id="{{ $btnId }}">
            <div class="flex flex-row">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="m-1 feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <div class="mt-0.5">{{ $btnLabel }}</div>
            </div>
        </button>
    </form>

</div>
