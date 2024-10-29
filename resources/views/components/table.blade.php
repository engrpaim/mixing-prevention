<div class="h-auto p-2 m-1 rounded hover:bg-red-50 w-96 md:m-4 md:mt-1 max-h-auto max-w-96 min-w-fit min-h-fit outline outline-1 outline-gray-300">



    <table class="flex h-auto p-2 md:flex-col ">
        <thead class="flex justify-center">
            <tr>
                <th>{{ $title }}</th>

                @php
                $parts = explode('-', $title)[0];
                $update = 'update-'.strtolower($parts).'-data-form';
                $delete = 'delete-'.strtolower($parts).'-data-form';
                @endphp


            </tr>
        </thead>
        <tbody >


            @if(count($array) <= 0)
                <td class="p-2 py-10 italic text-center bg-red-100 rounded-lg w-96 outline outline-2 outline-red-500 justify-content-center">No data found</td>
            @endif

            @foreach($array  as $data)
                <tr >
                     <td class="flex items-center justify-between p-3 m-1 bg-gray-100 rounded-sm hover:font-bold outline outline-gray-200 outline-1 hover:outline-2 hover:outline-yellow-300 hover:bg-yellow-50 w-96">{{ $data->{$column} }}
                        <div class="flex flex-row">
                        <a href="{{ url(strtolower($parts ."/").'edit/'.$data->id) }}" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 hover:text-blue-500" viewBox="0 -0.5 25 25" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7 5.12758L19.266 6.37458C19.4172 6.51691 19.5025 6.71571 19.5013 6.92339C19.5002 7.13106 19.4128 7.32892 19.26 7.46958L18.07 8.89358L14.021 13.7226C13.9501 13.8037 13.8558 13.8607 13.751 13.8856L11.651 14.3616C11.3755 14.3754 11.1356 14.1751 11.1 13.9016V11.7436C11.1071 11.6395 11.149 11.5409 11.219 11.4636L15.193 6.97058L16.557 5.34158C16.8268 4.98786 17.3204 4.89545 17.7 5.12758Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.033 7.61865C12.4472 7.61865 12.783 7.28287 12.783 6.86865C12.783 6.45444 12.4472 6.11865 12.033 6.11865V7.61865ZM9.23301 6.86865V6.11865L9.23121 6.11865L9.23301 6.86865ZM5.50001 10.6187H6.25001L6.25001 10.617L5.50001 10.6187ZM5.50001 16.2437L6.25001 16.2453V16.2437H5.50001ZM9.23301 19.9937L9.23121 20.7437H9.23301V19.9937ZM14.833 19.9937V20.7437L14.8348 20.7437L14.833 19.9937ZM18.566 16.2437H17.816L17.816 16.2453L18.566 16.2437ZM19.316 12.4937C19.316 12.0794 18.9802 11.7437 18.566 11.7437C18.1518 11.7437 17.816 12.0794 17.816 12.4937H19.316ZM15.8863 6.68446C15.7282 6.30159 15.2897 6.11934 14.9068 6.2774C14.5239 6.43546 14.3417 6.87397 14.4998 7.25684L15.8863 6.68446ZM18.2319 9.62197C18.6363 9.53257 18.8917 9.13222 18.8023 8.72777C18.7129 8.32332 18.3126 8.06792 17.9081 8.15733L18.2319 9.62197ZM8.30001 16.4317C7.8858 16.4317 7.55001 16.7674 7.55001 17.1817C7.55001 17.5959 7.8858 17.9317 8.30001 17.9317V16.4317ZM15.767 17.9317C16.1812 17.9317 16.517 17.5959 16.517 17.1817C16.517 16.7674 16.1812 16.4317 15.767 16.4317V17.9317ZM12.033 6.11865H9.23301V7.61865H12.033V6.11865ZM9.23121 6.11865C6.75081 6.12461 4.7447 8.13986 4.75001 10.6203L6.25001 10.617C6.24647 8.96492 7.58269 7.62262 9.23481 7.61865L9.23121 6.11865ZM4.75001 10.6187V16.2437H6.25001V10.6187H4.75001ZM4.75001 16.242C4.7447 18.7224 6.75081 20.7377 9.23121 20.7437L9.23481 19.2437C7.58269 19.2397 6.24647 17.8974 6.25001 16.2453L4.75001 16.242ZM9.23301 20.7437H14.833V19.2437H9.23301V20.7437ZM14.8348 20.7437C17.3152 20.7377 19.3213 18.7224 19.316 16.242L17.816 16.2453C17.8195 17.8974 16.4833 19.2397 14.8312 19.2437L14.8348 20.7437ZM19.316 16.2437V12.4937H17.816V16.2437H19.316ZM14.4998 7.25684C14.6947 7.72897 15.0923 8.39815 15.6866 8.91521C16.2944 9.44412 17.1679 9.85718 18.2319 9.62197L17.9081 8.15733C17.4431 8.26012 17.0391 8.10369 16.6712 7.7836C16.2897 7.45165 16.0134 6.99233 15.8863 6.68446L14.4998 7.25684ZM8.30001 17.9317H15.767V16.4317H8.30001V17.9317Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="{{ url(strtolower($parts ."/").'delete/'.$data->id) }}">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-8 mt-1.5 w-9 hover:text-red-600" viewBox="0 0 24 24" fill="none">
                                <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-center my-1 pagination">
        <?php
        $border = "flex items-center justify-center p-2 py-1 m-1 rounded-sm outline outline-1 outline-slate-300 hover:bg-gray-200";
        ?>
        @if ($array->hasPages())
            <span class="<?php echo $border?>">

                @if ($array->onFirstPage())
                    <span >&laquo;</span>
                @else
                    <a href="{{ $array->previousPageUrl() }}">&laquo;</a>
                @endif
            </span>

            <?php

                $currentPage = $array->currentPage();
                $start = max(1, $currentPage - 2);
                $end = min($array->lastPage(), $currentPage + 2);

                if ($currentPage <= 3) {
                    $end = min(5, $array->lastPage());
                } elseif ($currentPage >= $array->lastPage() - 1) {
                    $start = max(5, $array->lastPage() - 4);
                }


            ?>

            @for ($page = $start; $page <= $end; $page++)
                <span class="flex items-center justify-center p-2 py-1 m-1 rounded-sm cursor-default outline outline-1 outline-slate-300 hover:bg-gray-200">
                    @if ($page == $currentPage)
                        <strong>{{ $page }}</strong>
                    @else
                    <a href="{{ $array->url($page) }}">{{ $page }}</a>
                    @endif
                </span>
            @endfor
            <span class="<?php echo $border?>">
                @if ($array->hasMorePages())
                    <a href="{{ $array->nextPageUrl() }}">&raquo;</a>

                @else
                    <span>&raquo;</span>

                @endif
            </span>
        @endif


    </div>
    {{-- UPDATE FORM HANDLDER--}}
    @php
        $sessionDetect = '';


        if (session()->has('process_edit')) {
            $sessionDetect = 'process_edit';
        } elseif (session()->has('before_material_edit')) {
            $sessionDetect = 'before_material_edit';
        } elseif (session()->has('after_material_edit')) {
            $sessionDetect = 'after_material_edit';
        }else {
            $sessionDetect = 'none';
        }

    @endphp
    @if($sessionDetect && Str::contains($sessionDetect,strtolower($parts)))


        @if(session($sessionDetect))

            @php
                $attributes = session($sessionDetect)->getAttributes();
                $keys = array_keys($attributes);
            @endphp

            <div class="flex flex-col justify-center p-2 m-2 rounded-lg outline outline-1 outline-slate-300 bg-slate-100">
                <div >
                    <h2 class="flex justify-center w-80"><strong>UPDATE DETIALS</strong></h2>

                </div>
                <div class="flex flex-col p-2">

                    <form id="updateForm" name="updateForm" class="flex flex-col items-center justify-items-center" action="{{ route($update) }}" method="POST">
                        @csrf
                        <div class="self-start">CURRENT: <strong><input type="hidden" id="currentValue" name="currentValue" value="{{ $attributes[$keys[1]] }}" >{{ $attributes[$keys[1]] }}</strong> <br></div>

                        <div class="self-start">
                            UPDATE TO <input id="updateInput" name="updateInput" class="p-1 m-1 rounded-sm outline outline-2 hover:outline-slate-500 outline-slate-300 hover:bg-blue-100" required>
                        </div>
                        <button   button type="submit" id="updateButton" class="w-24 p-2 m-2 font-bold text-center text-blue-400 bg-blue-100 rounded-lg cursor-pointer hover:text-blue-800 hover:outline-blue-600 hover:bg-blue-200 outline outline-2 outline-blue-200">Update</button>
                    </form>
                </div>


            </div>


        @endif

    @endif

    {{-- DELETE FORM HANLDER --}}
    @php
    $sessionDelete = '';


    if (session()->has('process_delete')) {
        $sessionDelete = 'process_delete';
    } elseif (session()->has('before_material_delete')) {
        $sessionDelete = 'before_material_delete';
    } elseif (session()->has('after_material_delete')) {
        $sessionDelete = 'after_material_delete';
    }else {
        $sessionDelete = 'none';
    }
    @endphp
    @if(session($sessionDelete) && Str::contains($sessionDelete,strtolower($parts)))
        @php
            $attributes = session($sessionDelete)->getAttributes();
            $keys = array_keys($attributes);
           //dump(session($sessionDelete));
        @endphp


        <div class="flex flex-col justify-center p-2 m-2 bg-yellow-100 rounded-lg outline outline-1 outline-yellow-300">
            <div >
                <h2 class="flex justify-center w-80"><strong>DELETE DETIALS</strong></h2>

            </div>
            <div class="flex flex-col p-2">

                <form id="deleteForm" name="deleteForm" class="flex flex-col items-center justify-items-center" action="{{ route($delete) }}" method="POST">
                    @csrf
                    <div class="">Confirm delete <strong><input type="hidden" id="deleteVlaue" name="deleteVlaue" value="{{ $attributes[$keys[1]] }}" >{{ $attributes[$keys[1]] }}</strong> ?</div>
                    <div>
                        <button  type="button"  onclick="location.reload();" id="cancelButton" class="w-24 p-2 m-2 font-bold text-center text-green-400 bg-green-200 rounded-lg cursor-pointer hover:text-green-800 hover:outline-green-600 hover:bg-green-200 outline outline-2 outline-green-200">Cancel</button>
                        <button  type="submit" id="deleteButton" class="w-24 p-2 m-2 font-bold text-center text-red-400 bg-red-200 rounded-lg cursor-pointer hover:text-red-800 hover:outline-red-600 hover:bg-red-200 outline outline-2 outline-red-200">Delete</button>
                    </div>

                </form>
            </div>


        </div>
    @endif

    {{--MESSAGE HANDLER --}}
    @if(session('update') == $compare)
        <x-updatehandler update="{{ session('update') }}" compare={{ $compare }}/>
    @endif

</div>
