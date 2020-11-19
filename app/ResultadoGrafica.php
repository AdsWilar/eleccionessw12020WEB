<?php

namespace App;

class ResultadoGrafica
{
    public $siglaPartido;
    public $colorHex;
    public $porcentaje;
    public $votos;

    function __construct($siglaPartido, $colorHex, $porcentaje, $votos)
    {
        $this->siglaPartido = $siglaPartido;
        $this->colorHex = $colorHex;
        $this->porcentaje = $porcentaje;
        $this->votos = $votos;

    }
    
}