<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class provincia extends Model
{
    protected $table = 'Provincia';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable =[
    	
        'nombre',
        'idDepartamento'

      
        
    ];

    protected $guarded =[

    ];
}
