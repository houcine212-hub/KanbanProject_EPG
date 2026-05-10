@if ($paginator->hasPages())
<nav style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.25rem; border-top:1px solid var(--border);">

    <div style="font-size:0.78rem; color:var(--text3);">
        Affichage de
        <strong>{{ $paginator->firstItem() }}</strong>
        à
        <strong>{{ $paginator->lastItem() }}</strong>
        sur
        <strong>{{ $paginator->total() }}</strong>
        résultats
    </div>

    <div style="display:flex; flex-direction:row; gap:0.3rem; align-items:center;">

        @if ($paginator->onFirstPage())
            <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--surface2);color:var(--text3);opacity:0.4;cursor:not-allowed;">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--surface2);color:var(--text2);text-decoration:none;">«</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:var(--accent);color:white;font-weight:700;font-size:0.82rem;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--surface2);color:var(--text2);text-decoration:none;font-size:0.82rem;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--surface2);color:var(--text2);text-decoration:none;">»</a>
        @else
            <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--surface2);color:var(--text3);opacity:0.4;cursor:not-allowed;">»</span>
        @endif

    </div>
</nav>
@endif
