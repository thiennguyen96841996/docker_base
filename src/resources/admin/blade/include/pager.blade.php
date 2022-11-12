<div>{{ Renderer::renderPaginatorTotalLine() }}</div>
@if ($paginator->hasPages())
    <nav>
        <ul class="pagination d-flex justify-content-left">
            <li class="page-item @if ($paginator->onFirstPage()) disabled @endif">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            </li>

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item"><a class="page-link" href="#">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item">
                                <a class="page-link active">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
@endif
