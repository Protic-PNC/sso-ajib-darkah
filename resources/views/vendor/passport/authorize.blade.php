@extends('layouts.base')

@section('title', 'Authorization')

@section('body')
<div class="w-full flex justify-center">
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 mt-20 shadow-lg">
        <div class="flex flex-col items-center py-10">
            <img class="w-24 mb-3 rounded-full shadow-lg" src="{{ asset('images/logo.png') }}" alt="Bonnie image"/>
            <p class="">Authorize to</p>
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $client->name }}</h5>
            <span class="text-sm text-gray-700 dark:text-gray-400 mt-4">
                @if (count($scopes) > 0)
                    <div class="scopes">
                       <p class="font-semibold">This application will be able to:</p>

                       <ul class="list-disc ml-5">
                           @foreach ($scopes as $scope)
                               <li>{{ $scope->description }}</li>
                           @endforeach
                       </ul>
                    </div>
                @endif
            </span>
            <div class="grid grid-cols-2 gap-x-3 mt-4 md:mt-6">
                <!-- Cancel Button -->
                <form method="post" action="{{ route('passport.authorizations.deny') }}" class="">
                    @csrf
                    @method('DELETE')

                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                </form>

                <form method="post" action="{{ route('passport.authorizations.approve') }}">
                    @csrf

                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <button type="submit" class="inline-flex w-full items-center px-4 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Authorize</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
