@extends('layouts.base')

@section('body')
    <div class="relative">
        <x-navbar />
        <x-sidebar />

        <div class="ml-64 mt-16 p-10 bg-slate-50 min-h-screen">
            @yield('content')
        </div>
    </div>

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
