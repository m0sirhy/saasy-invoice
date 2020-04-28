@if ($paginator->hasPages())
<div class="px-5 py-5 bg-white flex flex-col xs:flex-row items-center xs:justify-between">
    <ul class="flex list-reset border border-grey-light rounded w-auto font-sans">
        @if (!$paginator->onFirstPage())
        <li><a class="block hover:text-white hover:bg-blue-900 text-blue border-r border-grey-light px-3 py-2" href="#">Previous</a></li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="block hover:text-white hover:bg-blue-900 text-blue border-r border-grey-light px-3 py-2" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif
               @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a class="block hover:text-white hover:bg-blue-900 text-blue border-r border-grey-light px-3 py-2" href="#"><span>{{ $page }}</span></a></li>
                        @else
                            <li><a class="block hover:text-white hover:bg-blue-900 text-blue border-r border-grey-light px-3 py-2" href="{{ $url }}"><span>{{ $page }}</span></a></li>
                        @endif
                    @endforeach
                @endif
        @endforeach
      <li><a class="block hover:text-white hover:bg-blue-900 text-blue px-3 py-2" href="#">Next</a></li>
    </ul>
</div>
<div class="text-center py-2 px-6">
    Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} out of {{ $paginator->total() }} results
</div>
@endif
