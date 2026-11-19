@if ($paginator->hasPages())
<nav aria-label="Pagination">
  <ul class="pagination mb-0" style="gap:3px;">

    {{-- Tombol Previous --}}
    @if ($paginator->onFirstPage())
      <li class="page-item disabled">
        <span class="page-link" aria-hidden="true" style="border-radius:6px !important;">&lsaquo;</span>
      </li>
    @else
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" style="border-radius:6px !important;">&lsaquo;</a>
      </li>
    @endif

    {{-- Nomor Halaman --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="page-item disabled">
          <span class="page-link" style="border-radius:6px !important;">{{ $element }}</span>
        </li>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <li class="page-item active" aria-current="page">
              <span class="page-link" style="border-radius:6px !important;">{{ $page }}</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $url }}" style="border-radius:6px !important;">{{ $page }}</a>
            </li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Tombol Next --}}
    @if ($paginator->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya" style="border-radius:6px !important;">&rsaquo;</a>
      </li>
    @else
      <li class="page-item disabled">
        <span class="page-link" aria-hidden="true" style="border-radius:6px !important;">&rsaquo;</span>
      </li>
    @endif

  </ul>
</nav>
@endif
