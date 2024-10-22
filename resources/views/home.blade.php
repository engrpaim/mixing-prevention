<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mixing Prevention</title>
</head>
<body>
    <h3>MIXING PREVENTION</h3>
    <p><i>Welcome to mixing prevention site.</i></p>
    <a href="{{ url('add') }}"><button >ADD MODEL</button></a>
    <a href="{{ url('check') }}"><button>CHECK MIXING</button></a>
    <a href="{{ url('sections') }}"><button>SECTIONS</button></a>
    <script type="text/javaScript" src={{ asset('js/home.js') }}></script>
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
</body>
</html>

