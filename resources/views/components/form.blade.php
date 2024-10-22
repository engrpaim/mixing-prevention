<div>
    <form name="{{ $formName }}" id="{{ $formId }}" method="{{ $method }}" action="{{ url($action) }}" >
        @csrf
        <label for="{{ $name }}">{{ $show }}</label>
        <input type="text" placeholder="{{ $placeholder }}" id="{{ $inputeId }}" name="{{ $inputName }}" required/>
        <button type="{{ $buttonType }}" onclick="{{ $buttonOnclick }}" style="display: {{ $style }}" name="{{ $btnName }}" id="{{ $btnId }}">{{ $btnLabel }}</button>
    </form>

</div>
