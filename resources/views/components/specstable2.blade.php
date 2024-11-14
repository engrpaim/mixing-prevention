<div class="flex flex-col items-center justify-center w-full">
    @foreach (session('processedData') as $data)
         @foreach ($data as $key => $value )
             @php

             $processNumber2 = explode('_',$key);
             $processNumber2 = (int)$processNumber2[1]+1;
             $arrayCount2 = count(session('processedData'));
             // color number value
             $colors2 = ["green" , "violet","red","blue","yellow","pink"];



             @endphp

             @if($processNumber2 > $min && $processNumber2 < $max )

                 <div class="flex flex-row ">
                     <x-processplates :color="$colors2[$processNumber2-1]" :value="$value" :processNumber="$processNumber2" :fourth="$fifth" />

             @endif

         @endforeach

     @endforeach

 </div>


