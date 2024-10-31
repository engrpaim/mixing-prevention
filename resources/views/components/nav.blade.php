

<div class="relative button-container">
    <a href="{{ url($route) }}">
        <button class="hover:text-{{$color}}-600 hover:shadow-lg hover:shadow-{{$color}}-500/50 text-gray-600  hover:bg-{{$color}}-200 bg-gray-200 hover:outline-{{$color}}-600  outline outline-1 outline-gray-300 hover:outline-2  left-0 p-2 mx-2 mt-4 mb-2 font-sans text-base rounded-lg hover:font-bold {{ $isLast }} hover:shadow-lg">
            <div class="flex flex-row">
                {!! $svg !!}
                {{ $title }}

            </div>
        </button>
    </a>

    <span class='tooltip bg-{{$color}}-600 px-1 w-52 min-w-fit text-center'>{{ $tooltip }}</span>
</div>



<style>
    .tooltip {
        display: none;
    }
    .button-container:hover .tooltip {
        display: block;
        position: absolute;
        border-radius: 0.5rem;
        color: white;
        font-size: 0.75rem;
        padding: 0.5rem;
    }
</style>
