<div>
    <table>
        <thead>
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
    <div class="pagination">
        {{-- Custom Pagination Links --}}
        @if ($array->hasPages())
            <span>
                {{-- Previous Page Link --}}
                @if ($array->onFirstPage())
                    <span>&laquo; Previous</span>
                @else
                    <a href="{{ $array->previousPageUrl() }}">&laquo; Previous</a>
                @endif
            </span>

            {{-- Page Number Links --}}
            @foreach ($array->getUrlRange(1, $array->lastPage()) as $page => $url)
                <span>
                    @if ($page == $array->currentPage())
                        <strong>{{ $page }}</strong>
                    @else
                    <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                </span>
            @endforeach

            {{-- Next Page Link --}}
            <span>
                @if ($array->hasMorePages())
                    <a href="{{ $array->nextPageUrl() }}">Next &raquo;</a>
                @else
                    <span>Next &raquo;</span>
                @endif
            </span>
        @endif
    </div>
</div>
