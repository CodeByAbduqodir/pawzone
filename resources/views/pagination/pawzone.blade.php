@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul style="display:flex; flex-wrap:wrap; gap:0.4rem; list-style:none; padding:0; margin:0; align-items:center; justify-content:center;">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; padding:0 0.75rem; border-radius:999px; background:rgba(15,23,42,0.04); border:1px solid rgba(15,23,42,0.08); color:#aab4c4; font-weight:600; font-size:0.9rem; cursor:not-allowed;">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; padding:0 0.75rem; border-radius:999px; background:#fff; border:1px solid rgba(15,23,42,0.10); color:#10233f; font-weight:600; font-size:0.9rem; text-decoration:none; box-shadow:0 4px 10px rgba(15,23,42,0.06); transition:all 0.18s ease;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 16px rgba(15,23,42,0.10)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 10px rgba(15,23,42,0.06)'">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; border-radius:999px; color:#aab4c4; font-weight:600; font-size:0.9rem;">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; border-radius:999px; background:linear-gradient(135deg,#3b82f6,#7c3aed); color:#fff; font-weight:700; font-size:0.9rem; box-shadow:0 6px 16px rgba(59,130,246,0.28);">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; border-radius:999px; background:#fff; border:1px solid rgba(15,23,42,0.10); color:#10233f; font-weight:600; font-size:0.9rem; text-decoration:none; box-shadow:0 4px 10px rgba(15,23,42,0.06); transition:all 0.18s ease;" onmouseover="this.style.transform='translateY(-1px)';this.style.background='rgba(59,130,246,0.06)'" onmouseout="this.style.transform='';this.style.background='#fff'">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; padding:0 0.75rem; border-radius:999px; background:#fff; border:1px solid rgba(15,23,42,0.10); color:#10233f; font-weight:600; font-size:0.9rem; text-decoration:none; box-shadow:0 4px 10px rgba(15,23,42,0.06); transition:all 0.18s ease;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 16px rgba(15,23,42,0.10)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 10px rgba(15,23,42,0.06)'">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span style="display:inline-flex; align-items:center; justify-content:center; min-width:2.4rem; height:2.4rem; padding:0 0.75rem; border-radius:999px; background:rgba(15,23,42,0.04); border:1px solid rgba(15,23,42,0.08); color:#aab4c4; font-weight:600; font-size:0.9rem; cursor:not-allowed;">
                        &raquo;
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
