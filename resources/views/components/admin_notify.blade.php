<div class="flex flex-col items-center text-center justify-items-center">

    @if (str_contains($notify,"exist"))
        <div class="p-2 bg-red-300 rounded success-message w-screen2 min-h-fit min-w-fit md:m-4 max-h-28 outline outline-1 outline-red-600">
           <strong>{{ $notify }}</strong>.
        </div>
    @else
        <div class="p-2 bg-green-300 rounded success-message w-screen2 min-h-fit min-w-fit md:m-4 max-h-28 outline outline-1 outline-green-600">
            <strong>{{ $notify }}</strong>.
        </div>
    @endif

</div>
