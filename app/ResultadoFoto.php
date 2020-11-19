<?php

namespace App;

class ResultadoFoto
{
    public $idPartido;
    public $votos;

    function __construct($idPartido, $votos)
    {
        $this->idPartido = $idPartido;
        $this->votos = $votos;

    }
    
}