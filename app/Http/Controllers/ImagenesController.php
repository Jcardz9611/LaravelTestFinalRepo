<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Auth;


class ImagenesController extends Controller
{
    public function moderator()
    {
        if(Auth::user()->role==1){
            return view('moderator');
        }else{
            return redirect('/');
        }
    }

    public function allowResponse(Request $request)
    {
        $imagen = Imagen::findOrFail($request->id);
        $imagen->estatus = 1;
        $imagen->save();
        return $request->id;

        
    }
}
