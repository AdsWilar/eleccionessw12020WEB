<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesa extends Model
{
    protected $table = 'Mesa';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
        
        'numero',
        'descripcion',
        'estado',
        'idEncargado',
        'idRecinto'

        
    ];

    protected $guarded =[

    ];
}
