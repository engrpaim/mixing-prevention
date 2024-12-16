<div class="flex flex-col items-end justify-end" >
    <div class="flex ">
        <button class="flex flex-col p-4 mx-2 mt-4 mb-2 font-sans text-base text-gray-600 rounded-md rigth-0 flex-cl min-w-fit outline outline-1 outline-gray-300 hover:shadow-lg hover:bg-blue-200" type="{{ $type }}" onclick="{{ $onclick }}" style="display: {{ $style }}" name="{{ $name }}" id="{{ $id }}">
            {{ $slot }}
        </button>
    </div>
</div>

