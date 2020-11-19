<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recinto extends Model
{
    protected $table = 'Recinto';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
    	
        'nombre',
        'codigo',
        'direccion',
        'lat',
        'lon',
        'idLocalidad'

      
        
    ];

    protected $guarded =[

    ];
}
