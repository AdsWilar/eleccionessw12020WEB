<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rol extends Model
{
    protected $table = 'Rol';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];


    public function users(){
        return $this->hasMany('App\User');
    }
}
