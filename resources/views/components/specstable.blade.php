
<div class="flex flex-col items-center justify-center w-screen ">
   @foreach (session('processedData') as $data)
        @foreach ($data as $key => $value )
            @php

            $processNumber= explode('_',$key);
            $processNumber = (int)$processNumber[1]+1;
            $arrayCount = count(session('processedData'));
            // color number value
            $colors = ["green" , "violet","red","blue","yellow","pink"];

            @endphp

            @if ($processNumber == 2)

                <div class="flex flex-col">
                    <x-processplates :color="$colors[$processNumber-1]" :value="$value" :processNumber="$processNumber" :fourth="$fourth" />

            @elseif($processNumber < 2)

                <div class="flex flex-row ">
                    <x-processplates :color="$colors[$processNumber-1]" :value="$value" :processNumber="$processNumber" :fourth="$fourth" />
            @endif

        @endforeach

    @endforeach

</div>

</div>






