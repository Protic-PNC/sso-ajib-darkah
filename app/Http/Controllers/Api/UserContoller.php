<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserContoller extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        $user->getRoleNames();

        return $user;
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $accessToken = $user->token();

        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->delete();
        $accessToken->delete();

        // return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }
}
