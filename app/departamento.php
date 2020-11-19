<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class departamento extends Model
{
    protected $table = 'Departamento';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
    	
        'nombre'
      
        
    ];

    protected $guarded =[

    ];
}
