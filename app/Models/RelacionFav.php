<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacionFav extends Model
{
    use HasFactory;
    protected $table = 'relacion_fav';
    public $timestamps = false;
}
