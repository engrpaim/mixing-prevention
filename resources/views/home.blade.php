<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mixing Prevention</title>
    <style>

        body {
            position: relative;
            margin: 0;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("{{ asset('icons/bg.webp') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.4;
            z-index: -1;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.all-nav')
    <div class="flex items-center justify-center text-center h-lvh outline outline-1 outline-gray-300">
        <div>
            <h3 class="font-serif text-6xl font-extrabold">MIXING PREVENTION</h3>
            <p  class="font-sans text-2xl"><i>Welcome to mixing prevention site.</i></p>
        </div>
        <script type="text/javaScript" src={{ asset('js/home.js') }}></script>
    </div>
  <x-footer/>

</body>
</html>

