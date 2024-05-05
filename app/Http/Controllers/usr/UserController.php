<?php

namespace App\Http\Controllers\usr;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = User::select('name', 'attendance', 'atten_confirm')->where('random_string', $request->random_string)->get()->first();

        if ($user) {
            return response([
                'message' => 'ok',
                'data' => $user
            ], 200);
        } else {
            return response([
                'message' => 'Guest not found'
            ], 417);
        }
    }

    public function countAttenConfirm()
    {
        $count = User::where('atten_confirm', 'confirmed')->count();

        return response([
            'message' => 'ok',
            'data' => $count
        ], 200);
    }

    public function attentConfirm(Request $request)
    {
        $randomString = $request['delinda'];

        $user = User::where('random_string', $randomString)->first();

        if ($user) {
            $user->update(['atten_confirm' => 'confirmed']);

            return response([
                'message' => 'confirm success'
            ], 200);
        } else {
            return response([
                'message' => 'error'
            ], 400);
        }
    }

    public function attentUnConfirm(Request $request)
    {
        $randomString = $request['delinda'];

        $user = User::where('random_string', $randomString)->first();

        if ($user) {
            $user->update(['atten_confirm' => '-']);

            return response([
                'message' => 'unconfirm success'
            ], 200);
        } else {
            return response([
                'message' => 'error'
            ], 400);
        }
    }
}
