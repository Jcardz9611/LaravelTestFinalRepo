<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use App\Models\User;
use App\Models\RelacionFav;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ImagenResource;


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

    public function index()
    {        
            return Imagen::select('imagenes.id_imagen as id_imagen','imagenes.nombre as nombre','imagenes.descripcion as descripcion','imagenes.ruta as ruta','imagenes.contador_fav as contador_fav','users.name as autor')
            ->leftjoin('users','users.id','imagenes.autor')
            ->where('imagenes.estatus',1)->paginate(5);
    }

    public function allowImages()
    {
        return ImagenResource::collection(Imagen::where('estatus',0)->get());
    }

    public function favSearch($id)
    {
        $user = Auth::user()->id;
        $count = RelacionFav::where('id_imagen',$id)->where('id_usuario',$user)->count();
        return $count;
    }

    public function dislikeHandler($id)
    {
        $user = Auth::user()->id;
        
        $imagen = Imagen::findOrFail($id);
        $imagen->contador_fav -= 1;
        $imagen->save();

        $relacion =RelacionFav::where('id_usuario',$user)->where('id_imagen',$id)->delete();

        $userFav = User::select('imagenes_fav')->where('id',$user)->get()[0];
        $userFav = explode(',', $userFav->imagenes_fav);
        $key = array_search($id, $userFav);
        unset($userFav[$key]);
        //array_push($userFav,$id);
        $userFav = implode (",", $userFav);
        $userSave =User::where('id',$user)->get()[0];
        $userSave->imagenes_fav = $userFav;
        $userSave->save();
        //return $userSave;


    }

    public function likeHandler($id)
    {
        $user = Auth::user()->id;
        
        $imagen = Imagen::findOrFail($id);
        $imagen->contador_fav += 1;
        $imagen->save();

        $relacion = new RelacionFav;
        $relacion->id_usuario = $user;
        $relacion->id_imagen = $id;
        $relacion->save();

        $userFav = User::select('imagenes_fav')->where('id',$user)->get()[0];
        $userFav = explode(',', $userFav->imagenes_fav);
        array_push($userFav,$id);
        $userFav = implode (",", $userFav);
        $userSave =User::where('id',$user)->get()[0];
        $userSave->imagenes_fav = $userFav;
        $userSave->save();
        //return $userFav; 
    }

    public function favorites()
    {
        $imgArray = Auth::user()->imagenes_fav;
        $imgArray = explode(',', $imgArray);
        $imagenes = Imagen::select('imagenes.id_imagen as id_imagen','imagenes.nombre as nombre','imagenes.descripcion as descripcion','imagenes.ruta as ruta','imagenes.contador_fav as contador_fav','users.name as autor')
        ->leftjoin('users','users.id','imagenes.autor')
        ->whereIn('id_imagen',$imgArray)->get();
        return $imagenes;
    }

    public function favCatalog()
    {
        return view('favorites');
    }
}
