<div class="p-2 rounded w-96 min-h-fit min-w-fit md:m-4 max-h-28 outline outline-1 outline-gray-300">
    <form class="flex flex-col items-center" name="{{ $formName }}" id="{{ $formId }}" method="{{ $method }}" action="{{ url($action) }}" >
        @csrf
        <div>
        <label for="{{ $name }}">{{ $show }}</label>
        <input class="p-1 rounded outline outline-1 outline-gray-300 hover:outline-blue-600 hover:outline-2 hover:bg-blue-200"  type="text" placeholder="{{ $placeholder }}" id="{{ $inputeId }}" name="{{ $inputName }}" required/>
    </div>
        <button class="left-0 p-2 m-4 font-sans text-base text-gray-600 rounded-md outline outline-1 outline-gray-300 hover:shadow-lg hover:bg-slate-200" type="{{ $buttonType }}" onclick="{{ $buttonOnclick }}" style="display: {{ $style }}" name="{{ $btnName }}" id="{{ $btnId }}">{{ $btnLabel }}</button>
    </form>

</div>
