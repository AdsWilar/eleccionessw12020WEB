<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class partido extends Model
{
    protected $table = 'Partido';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
    	
        'nombre',
        'sigla',
        'color'
        
    ];

    protected $guarded =[

    ];
}
