<div>
    @if (session('success'))
        <div >
            {{ session('process') }} <strong>{{ session('success') }}</strong> is successfully added
        </div>
    @endif
</div>
