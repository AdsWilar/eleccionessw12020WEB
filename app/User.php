<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'Usuario';
    protected $primaryKey = 'id';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'correo', 'nombre', 'apellido', 'ci', 'fechaNac', 'telefono', 'direccion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'//, 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */    
    /*
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/


    //Para hacer referencia a la tabla Rol
    public function rol(){
        return $this->belongsTo('App\rol');
    }
}
