

    @foreach(session('processIncluded') as $list)
        @foreach($list as $key => $processes)
           @if($value === $key)


                @php
                    $process = $key;
                    $dimensions = explode(';',$processes);
                @endphp
           @endif
        @endforeach
    @endforeach







    <div class="flex flex-row p-2 m-2 shadow-lg outline outline-2 outline-slate-100">
        <div class="flex flex-col items-center">
            <div class="flex flex-col m-2">
                <span >Process {{ $processNumber }} </span>

            </div>
            <div class="flex flex-col self-start min-w-full font-bold p-2 text-sm text-center w-72 bg-{{ $color }}-200 outline outline-1 outline-slate-200">
                <span name="process_{{ $processNumber }}" id="process_{{ $processNumber }}" >{{ $process }} </span>
                <input type="hidden" id="model_name{{ $processNumber }}" value="{{ $value }}"/>
            </div>
            @php
                $border = "class = border border-slate-300 px-4 py-2";
                $input = "outline outline-slate-300 outline-1 rounded-lg  hover:outline-blue-500 hover:bg-blue-200 hover:outline-2 text-center ";
            @endphp
            <table class="{{  $border  }} bg-{{ $color }}-50">
                <thead>
                    <tr >
                        <th class="px-4 py-2 font-semibold">SPECIFICATION</th>
                        <th colspan="2" class="{{  $border  }} font-semibold">TOLERANCE</th>
                    </tr>
                    <tr>
                        <th ></th>
                        <th class="{{  $border  }} font-semibold">MIN&nbsp;&nbsp;</th>
                        <th class="{{  $border  }} font-semibold">MAX&nbsp;&nbsp;</th>
                    </tr>
                </thead>

                <tbody class="{{  $border  }}">
                    @for($i = 0; $i <  count($dimensions); $i++)
                        @php
                            $inputName = strtolower($dimensions[$i]);
                            //dump($inputName);
                        @endphp
                        <tr>
                            <td class="{{  $border  }}">{{ $dimensions[$i] }}&nbsp;&nbsp;</td>
                            <td class="{{  $border  }}">MIN&nbsp;&nbsp;<input id="{{ $inputName }}_min" class="{{ $input  }}" type="number" step="0.01"/></td>
                            <td class="{{  $border  }}">MAX&nbsp;&nbsp;<input class="{{ $inputName }}_max" type="number" step="0.01"/></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

