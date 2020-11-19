<?php

namespace App;

use Storage;


class Error
{
    public static function guardar($nombreLog , \Throwable $th){

        $fileName = date('dmY')."_".date('His')."_".$nombreLog.".txt";

        $cadena = "";

        $getMessage = "<Message>".PHP_EOL."\t".$th->getMessage().PHP_EOL."<\Message>".PHP_EOL;
        $getCode = "<Code>".PHP_EOL."\t".$th->getCode().PHP_EOL."<\Code>".PHP_EOL;
        $getFile = "<File >".PHP_EOL."\t".$th->getFile().PHP_EOL."<\File>".PHP_EOL;
        $getLine = "<Line >".PHP_EOL."\t".$th->getLine ().PHP_EOL."<\Line>".PHP_EOL;

        $stringTrace = $th->getTraceAsString();
        $arrayTrace = explode("#" , $stringTrace);
        $n = count($arrayTrace);
        $trace = "";
        for ($i=0; $i < $n; $i++) { 
            $trace = $trace.$arrayTrace[$i].PHP_EOL;            
        }
        $getTrace = "<Stack Trace>".$trace."<\Stack Trace>";
        

        //$cadena = $th->__toString();
        $cadena = $getMessage.PHP_EOL.$getCode.PHP_EOL.$getFile.PHP_EOL.$getLine.PHP_EOL.$getTrace;

        Storage::disk('errores')->put($fileName , $cadena);
    }



    public static function guardarLog($tcNombre, $tcMensaje){
        if($tcMensaje === null){
            $tcMensaje="tcMensaje es NULL";
        }
        $fileName = date('dmY')."_".date('His')."_".$tcNombre.".txt";
        Storage::disk('LogNormal')->put($fileName , $tcMensaje);
    }
    
}

?>