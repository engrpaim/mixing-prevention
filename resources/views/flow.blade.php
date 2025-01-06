<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mixing: Flow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.all-nav')
    @dump(get_defined_vars())
    <div class="flex items-center justify-center">
        <div class="flex items-center justify-center w-screen m-2 shadow-lg outline outline-1 outline-slate-200 h-96 rounded-xl">
            <div class="flex">
                <div>
                    <h1><strong>Process:&nbsp;</strong></h1>
                </div>
                <div>
                    <h3>
                        {{ $process }}

                    </h3>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p class="font-sans text-xl">This is the footer content.</p>
    </footer>
</body>
</html>
