<div class="h-auto p-2 m-1 rounded w-96 md:m-4 md:mt-1 max-h-auto max-w-96 min-w-96 min-h-fit outline outline-1 outline-gray-300">



    <table class="flex flex-col p-2 h-72">
        <thead class="flex justify-center">
            <tr>
                <th>{{ $title }}</th>


            </tr>
        </thead>
        <tbody>
            @foreach($array  as $data)
                <tr>
                    <td>{{ $data->{$column} }}</td>
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




</div>
