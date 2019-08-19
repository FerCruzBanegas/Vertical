<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();


        $user = User::where('email', '=', request('username'))
        ->orWhere('name', request('username'))
        ->first();

        if (!$user) {
            return response()->json([
                'message' => message('MSG006'),
            ], 422);
        }

        if ($user->state === 0) {
            return response()->json([
                'message' => message('MSG007'),
            ], 422);
        }

        if (!Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => message('MSG006'),
            ], 422);
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => request('username'),
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => message('MSG006'),
            ], 422);
        }

        $data = json_decode($response->getContent());

        foreach ($user->profile->actions as $action) {
            if (strpos($action->method, '|') !== false) {
                $pipe      = explode('|', $action->method);
                $actions[] = $pipe[0];
                $actions[] = $pipe[1];
            } else {
                $actions[] = $action->method;
            }
        }

        $auth = [
            'id' => $user->id,
            'name' => $user->name,
            'perfil_id' => $user->profile_id,
            'email' => $user->email,
            'created' => $user->created_at,
            'acl' => $actions
        ];

        Cache::add('actions_' . $user->id, $actions);

        return response()->json([
            'access_token'  => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'user' => $auth,
            'status' => 200
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        $accessToken->revoke();

        if (Cache::has('actions_' . auth()->user()->id)) {
            Cache::forget('actions_' . auth()->user()->id);
        }

        return response()->json(['status' => 200], 200);
    }
}
