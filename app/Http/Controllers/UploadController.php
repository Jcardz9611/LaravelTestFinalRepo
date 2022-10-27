<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function handle(Request $request)
    {
        $user = Auth::user()->id;
        $estatus = null;
        if(Auth::user()->authorized==1){
            $estatus = 1;
        }else{
            $estatus = 0;
        }
            $pathToFile = $request->file('image')->storeAs('/img', $request->nombre.'.jpg');
            $imagen = new Imagen();
            $imagen->nombre = $request->nombre;
            $imagen->descripcion = $request->descripcion;
            $imagen->autor = $user;
            $imagen->estatus= $estatus;
            $imagen->ruta = 'img/'.$request->nombre.'.jpg';
            $imagen->save();
            return $imagen;
    }
}
