<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class candidato extends Model
{
    protected $table = 'Candidato';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
    	
        'nombre',
        'apellido',
        'ci',
        'fechaNac',
        'puesto',
        'idPartido'
        
    ];

    protected $guarded =[

    ];
}
