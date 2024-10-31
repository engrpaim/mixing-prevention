<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mixing Prevention</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.all-nav')
    <div class="h-lvh outline outline-1 outline-gray-300">
        <h3 class="font-serif text-6xl font-extrabold">MIXING PREVENTION</h3>
        <p  class="font-sans text-2xl"><i>Welcome to mixing prevention site.</i></p>
        <script type="text/javaScript" src={{ asset('js/home.js') }}></script>
    </div>

</body>
</html>

