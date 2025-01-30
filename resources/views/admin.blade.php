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
    <div class="flex flex-col items-center h-min-fit outline outline-1 outline-gray-300">
        <div class="flex flex-col items-center justify-center p-10 m-5 bg-blue-100 w-screen2 rounded-2xl">
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
                        <label for="manage" class="mr-1">ADMIN</label>
                        <input type="checkbox" name="admin" id="admin" class="mr-3"/>
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



        <div class="flex flex-col h-min-fit h-max-fit" >

            @if (isset($ipaddress) && !empty($ipaddress))
            <div class="flex flex-row items-center justify-center p-2 mb-5 w-screen2 ">

                    <table>
                        <thead>
                            <tr>
                                <th class="w-32 px-4 py-2 text-center border border-gray-300">I.P ADDRESS</th>
                                <th class="px-4 py-2 text-center border border-gray-300 w-80">NAME</th>
                                <th class="px-4 py-2 text-center border border-gray-300 w-96 ">PERMISSION</th>
                            </tr>
                        </thead>
                        <tbody>

                                @foreach ($ipaddress as $user)

                                    <tr>
                                        <form id="user-admin" name="user-admin" method="POST" action="{{ url('admin-update') }}" class="flex flex-row">
                                        @csrf
                                        <td class="p-2 border border-gray-300">
                                            <input class="p-2 placeholder-black" id="ip" name="ip" placeholder="{{$user->ip}}"/>
                                            <input type="hidden" id="current_ip" name="current_ip" value="{{$user->ip}}" placeholder="{{$user->ip}}"/>
                                        </td>
                                        <td class="p-2 border border-gray-300">
                                            <input class="p-2 placeholder-black" id="name" name="name" placeholder="{{$user->name}}"/>
                                            <input type="hidden" id="current_name" name="current_name" value="{{$user->name}}" placeholder="{{$user->name}}"/>
                                        </td>
                                        <td class="p-2 border border-gray-300">
                                        <div class="flex flex-row">
                                            <div class="flex items-center justify-center">
                                                @php
                                                    $permissions = [
                                                                        'Admin' => 'admin',
                                                                        'Manage' => 'manage',
                                                                        'View' => 'view',
                                                                        'Model' => 'model',
                                                                ];
                                                @endphp

                                                @foreach ( $permissions  as $key => $value)
                                                    <h3 class="pl-5 pr-1 font-semibold">{{  $key }}</h3>
                                                    <input type="checkbox" id="{{ $value }}_{{$user->name}}" name="{{ $value }}_{{$user->name}}" class="peer" {{ $user->$value === 'ON' ? 'checked' : '' }} />

                                                @endforeach

                                            </div>
                                            <div class="flex px-5">
                                                <button type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 hover:text-blue-500" viewBox="0 -0.5 29 29" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7 5.12758L19.266 6.37458C19.4172 6.51691 19.5025 6.71571 19.5013 6.92339C19.5002 7.13106 19.4128 7.32892 19.26 7.46958L18.07 8.89358L14.021 13.7226C13.9501 13.8037 13.8558 13.8607 13.751 13.8856L11.651 14.3616C11.3755 14.3754 11.1356 14.1751 11.1 13.9016V11.7436C11.1071 11.6395 11.149 11.5409 11.219 11.4636L15.193 6.97058L16.557 5.34158C16.8268 4.98786 17.3204 4.89545 17.7 5.12758Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M12.033 7.61865C12.4472 7.61865 12.783 7.28287 12.783 6.86865C12.783 6.45444 12.4472 6.11865 12.033 6.11865V7.61865ZM9.23301 6.86865V6.11865L9.23121 6.11865L9.23301 6.86865ZM5.50001 10.6187H6.25001L6.25001 10.617L5.50001 10.6187ZM5.50001 16.2437L6.25001 16.2453V16.2437H5.50001ZM9.23301 19.9937L9.23121 20.7437H9.23301V19.9937ZM14.833 19.9937V20.7437L14.8348 20.7437L14.833 19.9937ZM18.566 16.2437H17.816L17.816 16.2453L18.566 16.2437ZM19.316 12.4937C19.316 12.0794 18.9802 11.7437 18.566 11.7437C18.1518 11.7437 17.816 12.0794 17.816 12.4937H19.316ZM15.8863 6.68446C15.7282 6.30159 15.2897 6.11934 14.9068 6.2774C14.5239 6.43546 14.3417 6.87397 14.4998 7.25684L15.8863 6.68446ZM18.2319 9.62197C18.6363 9.53257 18.8917 9.13222 18.8023 8.72777C18.7129 8.32332 18.3126 8.06792 17.9081 8.15733L18.2319 9.62197ZM8.30001 16.4317C7.8858 16.4317 7.55001 16.7674 7.55001 17.1817C7.55001 17.5959 7.8858 17.9317 8.30001 17.9317V16.4317ZM15.767 17.9317C16.1812 17.9317 16.517 17.5959 16.517 17.1817C16.517 16.7674 16.1812 16.4317 15.767 16.4317V17.9317ZM12.033 6.11865H9.23301V7.61865H12.033V6.11865ZM9.23121 6.11865C6.75081 6.12461 4.7447 8.13986 4.75001 10.6203L6.25001 10.617C6.24647 8.96492 7.58269 7.62262 9.23481 7.61865L9.23121 6.11865ZM4.75001 10.6187V16.2437H6.25001V10.6187H4.75001ZM4.75001 16.242C4.7447 18.7224 6.75081 20.7377 9.23121 20.7437L9.23481 19.2437C7.58269 19.2397 6.24647 17.8974 6.25001 16.2453L4.75001 16.242ZM9.23301 20.7437H14.833V19.2437H9.23301V20.7437ZM14.8348 20.7437C17.3152 20.7377 19.3213 18.7224 19.316 16.242L17.816 16.2453C17.8195 17.8974 16.4833 19.2397 14.8312 19.2437L14.8348 20.7437ZM19.316 16.2437V12.4937H17.816V16.2437H19.316ZM14.4998 7.25684C14.6947 7.72897 15.0923 8.39815 15.6866 8.91521C16.2944 9.44412 17.1679 9.85718 18.2319 9.62197L17.9081 8.15733C17.4431 8.26012 17.0391 8.10369 16.6712 7.7836C16.2897 7.45165 16.0134 6.99233 15.8863 6.68446L14.4998 7.25684ZM8.30001 17.9317H15.767V16.4317H8.30001V17.9317Z" fill="currentColor"/>
                                                    </svg>
                                                </button>

                                                <a href="{{ url("user-delete/".$user->ip) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 mt-1.5 w-9 hover:text-red-600" viewBox="0 0 29 29" fill="none">
                                                        <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            </div>

                                        </form>

                                        </div>


                                        </td>
                                    </tr>


                                @endforeach

                        </tbody>
                    </table>

            </div>
            @else
                <div class="flex items-center justify-center my-2 mb-8 text-red-400 rounded-lg w-screen2 text center h-96 outline outline-2 outline-gray-200">
                    <h2><i>No I.P is allowed</i></h2>
                </div>
            @endif

        </div>

    </div>
    <script>
        const adminInputFields =document.querySelectorAll('input');

        adminInputFields.forEach(adminInputFields => {
            adminInputFields.addEventListener('input',function(){

                this.value = this.value.toUpperCase();

            });

        });
    </script>

<x-footer/>
</body>
</html>

{{--
@dump(get_defined_vars())
@dump(session()->all()) --}}
