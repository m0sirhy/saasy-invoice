<tbody>
    @foreach ($data as $cell)
    <tr class="hover:bg-grey-lighter">
        @foreach ($table as $name => $options)
            @if (empty($options))
            @continue
            @endif
            <td class="py-4 px-6 border-b border-grey-light">
                @if (isset($options['cell']['link']))
                <a href="{{ route($options['cell']['link']['route'], [$options['cell']['link']['params']['name'] => $cell[$options['cell']['link']['params']['value']]]) }}" class="{{ $options['cell']['link']['class'] }}">
                @endif
                @if(isset($options['carbon']))
                    {{ $cell[$options['cell']['display']]->format('m/d/y') }}
                @elseif (isset($options['dollar'])) 
                    @include('includes._dollar', ['text' => $cell[$options['cell']['display']]])
                @elseif (isset($options['limit']))
                    @include('includes._limit', ['text' => $cell[$options['cell']['display']]])
                @else
                    {{ $cell[$options['cell']['display']] }}
                @endif
                @if (isset($options['cell']['link']))
                </a>
                @endif
            </td>
        @endforeach
    </tr>
    @endforeach
</tbody>
