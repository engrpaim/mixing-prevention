@if (isset($display) && !empty($display) )


        @php
             $defaultValue = [
                'length' => 3,
                'width' => 2,
                'thickness' => 1.5,
             ];
        @endphp
        @foreach ($display as $createInputRange )

                @php
                    if(array_key_exists($createInputRange,$defaultValue)){
                        $defaultRange = $defaultValue[$createInputRange];
                    }else{
                        $defaultRange = 0;
                    }
                @endphp

                <input type="hidden" step="0.001" id="{{ $createInputRange }}_range" name="{{ $createInputRange }}_range"  value="{{ $defaultRange }}"/>

        @endforeach



@endif
