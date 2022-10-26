<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Imagen;
use App\Http\Resources\ImagenResource;
use Illuminate\Support\Facades\Auth;

class ImagenController extends Controller
{
   
    public function index()
    {
        if(Auth::check()){
            return 8;
        }
        
        /*if (Auth::guard()->check()) {
            $id = Auth::guard()->user()->id;
            return ImagenResource::collection(Imagen::select('imagenes.id_imagen as id_imagen','imagenes.nombre as nombre','imagenes.descripcion as descripcion','imagenes.ruta','imagenes.contador_fav as contador_fav','relacion_fav.id as relacion')
            ->leftjoin('relacion.fav','imagenes.id_imagen','=','relacion_fav.id_imagen')
            ->where('relacion_fav',$id)
            ->where('imagenes.estatus',1)->paginate(5));
        }else{
        
            return ImagenResource::collection(Imagen::where('estatus',1)->paginate(5));
        }*/
    }

    public function allowImages()
    {
        return ImagenResource::collection(Imagen::where('estatus',0)->get());
    }
}
