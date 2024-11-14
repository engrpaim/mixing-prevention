<div class="flex justify-center text-sm item-center">
    @if(session('success'))
        <div class="p-2 bg-red-300 rounded success-message w-72 min-h-fit min-w-72 md:m-1 max-h-28 outline outline-1 outline-red-600 ">
            <i>Attention:</i> <strong>{{ session('success') }}</strong> {{ session('process') }}!
        </div>
    @endif

</div>
