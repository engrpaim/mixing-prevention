

<div class="button-container">
    <a href="{{ url($route) }}"><button class="left-0 p-2 mx-2 mt-4 mb-2 font-sans text-base text-gray-600 rounded-md {{ $isLast }} outline outline-1 outline-gray-300 hover:shadow-lg hover:bg-slate-200">{{ $title }}</button></a>
    <span class='tooltip'>{{ $tooltip }}</span>
</div>

<style>
    .tooltip {
        display: none;

    }
    .button-container:hover .tooltip {
        display: block;
        position: absolute;
        background-color:#17202a;
        border-radius: 0.5rem;
        color:white;
        font-size:0.75rem;
        padding:0.5rem;


    }
</style>
