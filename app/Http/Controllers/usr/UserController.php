<?php

namespace App\Http\Controllers\usr;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function sendGreetings(Request $request)
    {
        $random_string = $request['delinda'];

        $user = DB::table('users')->where('random_string', $random_string)->first();

        if ($user) {

            $sanitizedGreetings = $this->sanitizeInput($request['greetings']);

            $user->greetings = $sanitizedGreetings;
            $user->save();

            return response()->json([
                'message' => 'successfully sent!'
            ]);
        } else {

            return response()->json([
                'message' => 'Validation failed!'
            ], 400);
        }
    }

    function sanitizeInput($input)
    {
        return trim(htmlspecialchars($input));
    }
}
