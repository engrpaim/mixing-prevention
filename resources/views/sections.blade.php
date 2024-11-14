<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" required>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mixing: Section</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div >
    <div class="flex flex-col items-center justify-center mx-0 text-base min-w-fit">
        @include('components.all-nav')
        @include('components.all-tables')
    </div>
</div>





<script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>

</body>
</html>
