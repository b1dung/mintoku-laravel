@if ($paginator->hasPages())
<div class="pagination center">
    <ul>
        @if (!$paginator->onFirstPage())
        <li><a href="{{ $paginator->url(1) }}" class="btnPage notranslate"><i class="fa fa-angle-double-left"></i></a></li>
        @endif

        @if ($paginator->onFirstPage())
        @else
        <li><a href="{{ $paginator->previousPageUrl() }}" class="btnPage notranslate"><i class="fa fa-angle-double-right" style="transform: rotate(180deg); display: inline-block;"></i></a></li>
        @endif

        @foreach ($elements as $element)
        @if (is_string($element))
        <li><span class="pagecur notranslate">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li><span class="pagecur notranslate">{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}" class="pagelink notranslate">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" class="btnPage notranslate"><i class="fa fa-angle-double-right"></i></a></li>
        @else
        @endif
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->url($paginator->lastPage()) }}" class="btnPage notranslate"><i class="fa fa-angle-double-right"></i></a></li>
        @endif
    </ul>
</div>
@endif