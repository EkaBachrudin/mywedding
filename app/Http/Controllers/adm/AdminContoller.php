<?php

namespace App\Http\Controllers\adm;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class AdminContoller extends Controller
{
    public function administrator(Request $request): View
    {
        $keyword = $request->search;
        if ($keyword) {
            $datas = User::whereHas('roles', function (Builder $query) use ($keyword) {
                $query->where('id', 'like', '2');
            })->where('name', 'like', "%" . $keyword . "%")->paginate(100);
        } else {
            $datas = User::whereHas('roles', function (Builder $query) {
                $query->where('id', 'like', '2');
            })->paginate(100);
        }

        return view('adm.pages.index', compact('datas'));
    }

    public function getGust($id)
    {
        $user = User::select('name', 'attendance', 'atten_confirm')->where('id', $id)->get()->first();

        return response([
            'message' => 'ok',
            'data' => $user
        ], 200);
    }

    public function updateGuest($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->save();

        $user = User::select('name', 'attendance', 'atten_confirm')->where('id', $id)->get()->first();

        return response([
            'message' => 'Updated guest success',
            'data' => $user
        ], 200);
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
                'url' => 'https://wedding.nursa.fun/' . $url_param,
                'password' => Hash::make($underscore_replace . $url_param),
            ]);

            $roleIds = [2];
            $user->roles()->attach($roleIds);
        }


        return redirect('/administrator');
    }

    public function deleteGuest(Request $request)
    {
        UserRole::whereIn('user_id', $request->guests)->delete();
        User::whereIn('id', $request->guests)->delete();
        return response([
            'message' => 'Success delete guests',
        ], 200);
    }
}
