<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function authUsers()
    {
        if(Auth::user()->role==1){
            $users = User::where('authorized',0)->get();
            return view('users.authorization', compact('users'));
        }else{
            return redirect('/');
        }
    }

    public function authForm($id)
    {
        $user = User::findOrFail($id);
        return view('users.authForm', compact('user'));
    }

    public function saveAuth(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->authorized = $request->authorized;
        $user->save();
        return redirect('/');
    }
}
