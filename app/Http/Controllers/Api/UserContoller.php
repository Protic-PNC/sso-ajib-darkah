<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserContoller extends Controller
{
    public function authUser(Request $request)
    {
        $user = $request->user();
        $user->getRoleNames();

        return $user;
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $accessToken = $user->token();

        // DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->delete();
        // $accessToken->delete();

        // return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }

    public function user(Request $request)
    {
        try{
            if($request->id){
                $user = User::with('roles')->where('id', $request->id)->first();
            }else{
                $user = User::with('roles')->get();
            }
            
            return response()->json([
                'message' => 'success',
                'data' => $user,
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
