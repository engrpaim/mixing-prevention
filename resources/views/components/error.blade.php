<div>
    @if(session('success'))
        <div class="p-2 bg-red-300 rounded success-message w-96 min-h-fit min-w-fit md:m-4 max-h-28 outline outline-1 outline-red-600 ">
            <i>Attention:</i> <strong>{{ session('success') }}</strong> {{ session('process') }}!
        </div>
    @endif

</div>
