<div class="success-message" style="display: block;" >
    @if ($process  == $compare )
            <br />
            <x-sucess/>
            <br />
            @php
    $sessionDetect = '';


    if (session()->has('process_edit')) {
        $sessionDetect = 'process_edit';
    } elseif (session()->has('before_material_edit')) {
        $sessionDetect = 'before_material_edit';
    } elseif (session()->has('after_material_edit')) {
        $sessionDetect = 'after_material_edit';
    }else {
        $sessionDetect = 'none';
    }

@endphp
@if(session($sessionDetect))

    @php
        $attributes = session($sessionDetect)->getAttributes();
        $keys = array_keys($attributes);
    @endphp

        <p>{{$attributes[$keys[1]]}}</p>

@endif
    @elseif ($process  == $compareErr )
            <br/>
            <x-error/>
            <br/>
    @endif
</div>


