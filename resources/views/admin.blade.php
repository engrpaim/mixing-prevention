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
    <div class="flex flex-col items-center h-lvh outline outline-1 outline-gray-300">
        <div class="flex flex-col items-center justify-center p-10 m-5  bg-blue-100 w-screen2  rounded-2xl">
            <h1 class="mb-5 font-bold">ADD USER</h1>
            <form id="add-user" name="add-user" method="post" action="{{ url('admin-user') }}">
                @csrf
                <div class="">
                    <div class="flex flex-row h-fit">
                        @php
                            $ipdesign = "w-20 px-2 py-2  rounded-lg outline outline-1 outline-gray-400 text-center";
                        @endphp

                        <h1 class="mt-2 mr-2">I.P ADDRESS:</h1>
                        <input type="number" name="slot1" id="slot1" class="{{$ipdesign}}" required/><h1 class="mx-1 mt-4 font-bold">.</h1>
                        <input type="number" name="slot2" id="slot2" class="{{$ipdesign}}" required/><h1 class="mx-1 mt-4 font-bold">.</h1>
                        <input type="number" name="slot3" id="slot3" class="{{$ipdesign}}" required/><h1 class="mx-1 mt-4 font-bold">.</h1>
                        <input type="number" name="slot4" id="slot4" class="{{$ipdesign}}" required/>
                    </div>

                    <div class="flex flex-col my-5">
                        <div class="mb-5">
                            <label for="name">NAME</label>
                            <input name="name" id="name" class="{{$ipdesign}} w-52" required/>
                        </div>
                        <div class="mb-5">
                            <label for="area">AREA</label>
                            <input name="area" id="area" class="{{$ipdesign}} w-52"required/>
                        </div>
                    </div>

                    <div class="flex flex-row">
                        <label for="manage" class="mr-1">MANAGE</label>
                        <input type="checkbox" name="manage" id="manage" class="mr-3"/>
                        <label for="manage" class="mr-1">MODEL DETAILS</label>
                        <input type="checkbox" name="model" id="model" class="mr-3"/>
                        <label for="manage" class="mr-1">VIEW ALL</label>
                        <input type="checkbox" name="view" id="view" class="mr-3"/>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-10">
                    <button type="submit" class="py-3 bg-yellow-100 rounded-xl px-7 hover:bg-yellow-500 hover:font-bold">ADD</button>
                </div>
            </form>
            <div class="h-10">
                @if (isset(get_defined_vars()['error']))
                    <x-admin_notify notify="{{ get_defined_vars()['error'] }}"/>
                @elseif (isset(get_defined_vars()['success']))
                    <x-admin_notify notify="{{ get_defined_vars()['success'] }}"/>
                @endif
            </div>

        </div>
        <script type="text/javascript" src="js/allCaps.js"></script>
    </div>
  <x-footer/>

</body>
</html>

@dump(get_defined_vars())
@dump(session()->all())
