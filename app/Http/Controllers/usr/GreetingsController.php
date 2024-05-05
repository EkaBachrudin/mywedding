<?php

namespace App\Http\Controllers\usr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Greetings;
use App\Models\User;

class GreetingsController extends Controller
{
    public function getAllGreetings()
    {
        $dataResponse = [];
        $greetingsData = Greetings::with('user')->get();

        foreach ($greetingsData as $greetings) {

            array_push($dataResponse, [
                'username' => $greetings->user->name,
                'greetings' => $greetings->greetings
            ]);
        }

        return response()->json([
            'message' => 'success get greetings data!',
            'data' => $dataResponse
        ], 400);
    }

    public function sendGreetings(Request $request)
    {
        $random_string = $request['delinda'];

        $user = User::where('random_string', $random_string)->first();

        $userId = $user->id;

        if ($user) {

            $this->createGreetingData($userId, $request['greetings'], $user);

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

    function createGreetingData($userId, $greetingsValue, $user)
    {
        $greetingsData = Greetings::whereHas('user', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->first();

        $sanitizedGreetings = $this->sanitizeInput($greetingsValue);

        if ($greetingsData) {

            $greetingsData->update(['greetings' => $sanitizedGreetings]);
        } else {

            $greetings = new Greetings([
                'greetings' => $sanitizedGreetings,
            ]);

            $user->greetings()->save($greetings);
        }
    }
}
