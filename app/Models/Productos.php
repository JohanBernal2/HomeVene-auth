<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Productos extends Model
{

     protected $fillable = [
         'nombre_producto', 'precio'
     ];

    //protected $table = "producto";

}
