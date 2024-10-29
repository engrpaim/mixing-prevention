<div class="flex flex-col items-center text-center justify-items-center">
    @if($update == $compare )

        @if (session('new'))
            <div class="p-2 bg-green-300 rounded success-message w-72 min-h-fit min-w-fit md:m-4 max-h-28 outline outline-1 outline-green-600">
                {{ session('update') }} <strong>{{ session('current') }}</strong> {{ session('edited') }} <strong>{{ session('new') }}</strong>.
            </div>
        @elseif (session('exist'))
            <div class="p-2 bg-red-300 rounded success-message w-72 min-h-fit min-w-fit md:m-4 max-h-28 outline outline-1 outline-red-600">
                {{ session('update') }} <strong>{{ session('exist') }}</strong> {{ session('error') }}
            </div>
        @endif

    @endif
</div>
