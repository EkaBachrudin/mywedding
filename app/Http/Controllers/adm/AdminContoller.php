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

            $url_param = Str::random(6);

            $user = User::create([
                'name' => $value,
                'email' => '-',
                'address' => '-',
                'attendance' => 'no attendance',
                'url' => 'https://nursa.fun/wedding/' . $url_param,
                'password' => Hash::make(Crypt::encryptString($url_param)),
            ]);

            $roleIds = [2];
            $user->roles()->attach($roleIds);
        }


        return redirect('/administrator');
    }
}
