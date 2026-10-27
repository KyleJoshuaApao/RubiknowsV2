@if ($paginator->hasPages())
    <nav class="rk-pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="rk-pagination__step" aria-disabled="true">Previous</span>
        @else
            <a class="rk-pagination__step" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        @endif

        <ol>
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span aria-hidden="true">&hellip;</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" aria-label="Page {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ol>

        @if ($paginator->hasMorePages())
            <a class="rk-pagination__step" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
            <span class="rk-pagination__step" aria-disabled="true">Next</span>
        @endif
    </nav>
@endif
