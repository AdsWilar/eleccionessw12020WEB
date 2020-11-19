<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class actavotos extends Model
{
    protected $table = 'ActaVotos';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
    	
        'cantTotal',
        'votosNuelos',
        'votosBlanco',
        'fecha',
        'hora',
        'idMesa'
        
    ];

    protected $guarded =[

    ];
}
