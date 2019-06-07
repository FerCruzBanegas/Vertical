<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $data = [
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
        ];

        if (request('refresh_token')) {
            $data['grant_type'] = 'refresh_token';
            $data['refresh_token'] = request('refresh_token');

        } else {
            $user = User::where('email', '=', request('username'))
            ->orWhere('name', request('username'))
            ->first();

            if (!$user) {
                return response()->json([
                    'message' => '1',
                    'status'  => 422,
                ], 422);
            }

            if ($user->state === 0) {
                return response()->json([
                    'message' => message('MSG007'),
                    'status'  => 422,
                ], 422);
            }

            if (!Hash::check(request('password'), $user->password)) {
                return response()->json([
                    'message' => '2',
                    'status'  => 422,
                ], 422);
            }

            $data['grant_type'] = 'password';
            $data['username'] = $user->email;
            $data['password'] = request('password');

            foreach ($user->profile->actions as $action) {
                if (strpos($action->method, '|') !== false) {
                    $pipe      = explode('|', $action->method);
                    $actions[] = $pipe[0];
                    $actions[] = $pipe[1];
                } else {
                    $actions[] = $action->method;
                }
            }

            Cache::add('actions_' . $user->id, $actions, 120);
        }     

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => '3',
                'status'  => 422,
                'data' => $data
            ], 422);
        }

        $data = json_decode($response->getContent());

        $user = User::where('email', '=', 'nano.fer777@gmail.com')
            ->first();

        foreach ($user->profile->actions as $action) {
                if (strpos($action->method, '|') !== false) {
                    $pipe      = explode('|', $action->method);
                    $actions[] = $pipe[0];
                    $actions[] = $pipe[1];
                } else {
                    $actions[] = $action->method;
                }
            }

            Cache::add('actions_' . $user->id, $actions, 120);


        return response()->json([
            'access_token'  => $data->access_token,
            'refresh_token' => $data->refresh_token,
        ], 200);
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
