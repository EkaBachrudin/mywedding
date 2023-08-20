<?php

namespace App\Http\Controllers\adm;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder;

class AdminContoller extends Controller
{
    public function index()
    {
        $datas = User::whereHas('roles', function (Builder $query) {
            $query->where('id', 'like', '2');
        })->get();

        return view('adm.pages.index', compact('datas'));
    }

    public function customRegistration(Request $request)
    {

        $datas = $request->name;

        foreach ($datas as $key => $value) {
            $request->validate([
                'name.*' => ['required', 'string', 'max:255']
            ]);

            $url_param = Str::random(8);
            $underscore_replace = str_replace(' ', '_', $value);

            $user = User::create([
                'random_string' => $url_param,
                'name' => $value,
                'email' => '-',
                'address' => '-',
                'attendance' => '-',
                'atten_confirm' => '-',
                'url' => 'https://nursa.fun/wedding/' . $url_param,
                'password' => Hash::make($underscore_replace . $url_param),
            ]);

            $roleIds = [2];
            $user->roles()->attach($roleIds);
        }


        return redirect('/administrator');
    }
}
