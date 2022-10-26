<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function handle(Request $request)
    {
        $user = Auth::user()->id;
        if(Auth::user()->role==1){
            $pathToFile = $request->file('image')->storeAs('/img', $request->nombre.'.jpg');
            $imagen = new Imagen();
            $imagen->nombre = $request->nombre;
            $imagen->descripcion = $request->descripcion;
            $imagen->autor = $user;
            $imagen->ruta = 'img/'.$request->nombre.'.jpg';
            $imagen->save();
        }
        
    }
}
