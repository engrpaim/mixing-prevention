<div class="flex flex-row items-center justify-center p-3 m-2 shadow-lg rounded-xl w-72 h-fit outline outline-1 outline-slate-200 min-h-fit">
    <div class="flex flex-row">
        <div class="flex flex-col items-center">
            <div class="flex flex-col m-2">
                <span class="">Process {{ $processNumber }} </span>
            </div>
            <div class="flex flex-col self-start min-w-full p-2 text-sm text-center w-72 bg-{{ $color }}-200 outline outline-1 outline-slate-200">
                <span name="process_{{ $processNumber }}" id="process_{{ $processNumber }}" >{{ $value }} </span>
                <input type="hidden" id="model_name{{ $processNumber }}" value="{{ $value }}"/>
            </div>
        </div>
    </div>
</div>
