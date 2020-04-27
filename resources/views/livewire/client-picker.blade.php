<div>
    <label class="form-label">Client</label>
    <div class="flex-col">
        <div 
            x-data="{clientOpen: false}"
            x-cloak
        >
        <div class="w-full"> 
            <input id="clientSearch" class="drop-button shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight placeholder-gray-700 focus:outline-none focus:shadow-outline" type="text"
            placeholder="{{$clientPlaceholder}}"
            onkeyup="searchClients()" 
            x-on:focus="gainedFocus('#clientSearch'); clientOpen = true"
            x-on:keydown.escape="lostFocus('#clientSearch', clientOpen); clientOpen = false"
            x-on:click.away="lostFocus('#clientSearch', clientOpen); clientOpen = false">
            <div x-show="clientOpen">
                {{-- 4 or more clients with scroll --}}
                @if($clients->count() > 3)
                <div id="clientDropdown" class="w-1/3 absolute bg-white border border-solid border-gray-600 overflow-y-auto overflow-x-hidden h-32 rounded">
                    @foreach($clients as $client)
                        @if(!$loop->last)
                        <button class="py-2 pl-3 border-b border-solid border-gray-600 w-full text-left hover:bg-gray-600 hover:text-white" wire:click="clientClicked('{{$client->id}}', '{{$client->name}}', '{{$client->email}}')">
                        {{$client->name}} - {{$client->email}}</button>
                        @else
                            <button class="py-2 pl-3 border-b-none border-solid border-gray-600 w-full text-left hover:bg-gray-600 hover:text-white" wire:click="clientClicked('{{$client->id}}', '{{$client->name}}', '{{$client->email}}')">
                            {{$client->name}} - {{$client->email}}</button>
                        @endif
                    @endforeach
                </div>
                {{-- Fewer than 4 Clients --}}
                @elseif($clients->count() <= 3 && $clients->count() != 0 )
                <div id="clientDropdown" class="w-1/3 absolute bg-white border border-solid border-gray-600 rounded overflow-hidden">
                    @foreach($clients as $client)
                        @if(!$loop->last)
                        <button class="py-2 pl-3 border-b border-solid border-gray-600 w-full text-left hover:bg-gray-600 hover:text-white" wire:click="clientClicked('{{$client->id}}', '{{$client->name}}', '{{$client->email}}')">
                        {{$client->name}} - {{$client->email}}</button>
                        @else
                            <button class="py-2 pl-3 border-b-none border-solid border-gray-600 w-full text-left hover:bg-gray-600 hover:text-white" wire:click="clientClicked('{{$client->id}}', '{{$client->name}}', '{{$client->email}}')">
                            {{$client->name}} - {{$client->email}}</button>
                        @endif
                    @endforeach
                </div>
                {{-- No Clients --}}
                @else
                    <div id="clientDropdown" class="w-1/3 absolute bg-white border border-solid border-gray-600 rounded overflow-hidden">
                        <div class="py-2 pl-3">
                            No Clients Found
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

@push('alpineScripts')
<script type="text/javascript">
    var clientText = '';
    var clientTimeout;

    function gainedFocus(id)
    {
        div = $(id);
        clientText = div.val();
        div.val('');
        window.livewire.emit('clientStateChange');
    }

    function lostFocus(id, clientOpen)
    {
        div = $(id);
        div.val('');
        if (clientOpen) {
            window.livewire.emit('clientStateChange');
        }
    }

    function searchClients()
    {
        clearTimeout(clientTimeout);

        search = $('#clientSearch').val();
        clientTimeout = setTimeout(function() {
            window.livewire.emit('clientSearch', search);
        }, 333);
    }
</script>
@endpush
