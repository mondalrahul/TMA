@if (count($data) > 0)
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($data->currentPage() == 1)
            <li class="page-item disabled"><span class="page-link">First</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{$data->url(1)}}">First</a></li>
            <li class="page-item"><a class="page-link" href="{{$data->previousPageUrl()}}" rel="prev">Previous</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($data->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{$data->nextPageUrl()}}" rel="next">Next</a></li>
            <li class="page-item"><a class="page-link" href="{{$data->url($data->lastPage())}}" rel="next">Last</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Last</span></li>
        @endif
    </ul>
@endif
