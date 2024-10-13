@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif


@push('styles')
    <style>
        /* Pagination Container */
        .pagination {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            list-style: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        /* Pagination Links */
        .pagination li a,
        .pagination li span {
            padding: 10px 15px;
            margin: 0 5px;
            font-size: 14px;
            font-weight: 600;
            color: #ff0026;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Active Page Styling */
        .pagination li.active span {
            background-color: #ff0026;
            color: #fff;
            border-color: #ff0026;
        }

        /* Disabled Links */
        .pagination li.disabled span,
        .pagination li.disabled a {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }

        /* Hover Effects */
        .pagination li a:hover {
            background-color: #ff0026;
            color: white;
            border-color: #ff0026;
        }

        /* Customize Previous and Next Buttons */
        .pagination li:first-child a::before {
            content: "«"; /* Previous */
        }

        .pagination li:last-child a::after {
            content: "»"; /* Next */
        }

        /* Make pagination responsive */
        @media (max-width: 768px) {
            .pagination li a,
            .pagination li span {
                padding: 8px;
                margin: 0 3px;
                font-size: 12px;
            }
        }


    </style>
@endpush
