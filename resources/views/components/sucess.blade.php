<div>
    @if (session('success'))
        <div class="p-2 bg-green-300 rounded success-message w-80 min-h-fit min-w-fit md:m-1 max-h-28 outline outline-1 outline-green-600">
            {{ session('process') }} <strong>{{ session('success') }}</strong> is successfully added
        </div>
    @endif
</div>
