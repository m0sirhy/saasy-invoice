@extends('layouts.app')
@section('title', 'Users')
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('settings') }}">Settings</a> / Users</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Users</h5> 
            </div>
            <div class="p-5">
              <a href="{{ route('user.create') }}">
              <button class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fa fa-plus pr-0 md:pr-3"></i>
                <span>New User</span>
              </button>
              </a>
              <table class="table-fixed w-full  sm:bg-white rounded-lg sm:shadow-lg my-5">
                <thead>
                  <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td class="border px-4 py-2"><a href="{{ route('user.show', ['user' => $user->id]) }}" class="link">{{ $user->name }}</a></td>
                    <td class="border px-4 py-2"><a href="mailto:{{ $user->email }}" class="link">{{ $user->email }}</td>
                    <td class="border px-4 py-2">
                      @if ($user->token != '')
                      Invite Sent
                      @elseif ($user->active == 1)
                      Active
                      @else
                      Inactive
                      @endif
                    </td> 
                    <td class="border px-4 py-2">858</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <div class="w-full md:w-1/2 xl:w-1/6 p-3">
        @include('settings.nav')
    </div>
</div>
@endsection
