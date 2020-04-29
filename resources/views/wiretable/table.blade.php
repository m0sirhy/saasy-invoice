@extends('layouts.app')

@section('title', $wiretable->title)

@section('content')

@livewireStyles

<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">{{ $wiretable->title }}</h3>
</div>
<div class="p-5">
    @if ($wiretable->create != "")
    <a href="{{ route($wiretable->create) }}">Create New</a>
    @endif
	@livewire('wire.table', ['table' => $wiretable->table, 'model' => $wiretable->model, 'joins' => $wiretable->joins])
</div>
@endsection

@livewireScripts
@push('footerScripts')

@endpush