<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;


     protected $fillable = [
        'rol_id', 'nombre', 'apellido', 'documento_identificacion',
        'email','password', 'direccion','is_verified'
     ];
   // protected $table = "users";

     protected $hidden = [
         'clave', 'remember_token',
     ];




     public function getJWTIdentifier()
     {
         return $this->getKey();
     }

     public function getJWTCustomClaims()
     {
         return [];
     }
}
