<?php

namespace App\Http\Controllers\usr;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

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
}
