<div class="flex items-center justify-center mb-2 text-sm">
    @if (session('success'))
        <div class="w-64 p-2 bg-green-300 rounded success-message min-h-fit min-w-fit md:m-1 max-h-28 outline outline-1 outline-green-600">
            {{ session('process') }} <strong>{{ session('success') }}</strong> is successfully added
        </div>
    @endif
</div>
