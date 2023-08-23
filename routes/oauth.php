<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/oauth/logout', function (Request $request) {
    $client = DB::table('oauth_access_tokens')->where('client_id', $request->client_id)->first();
    if ($client) {
        $user = $request->user()->token();
        $user->revoke();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect($request->redirect_uri);
    }

    return redirect($request->redirect_uri);
})->middleware('auth')->name('oauth.logout');
