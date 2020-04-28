<thead>
    <tr>
        @foreach ($table as $name => $options)
            @if (!isset($options['header']))
                @continue;
            @endif
            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light>">
                @if ($options['header']['sort'] === true)
                <a wire:click.prevent="sortBy('{{ $name }}')" role="button" href="#">
                @endif
                {{ $options['header']['title'] }}
                @if ($options['header']['sort'] === true)
                @include('includes._sort-icon', ['field' => $name])
                @endif
                </a>
            </th>
        @endforeach
    </tr>
</thead>
