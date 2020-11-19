<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class encargado extends Model
{
    protected $table = 'Encargado';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
        
        'login',
        'password',
        'correo',
        'nombre',
        'apellido',
        'ci',
        'fechaNac',
        'telefono',
        'direccion'
        
    ];

    protected $guarded =[

    ];
}
