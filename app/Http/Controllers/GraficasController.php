<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ResultadoGrafica;

use Maatwebsite\Excel\Facades\Excel;
use PDF;
use View;
use DB;

use App\Exports\ResultadosExport;


class GraficasController extends Controller
{
    public function resultadosTotales()
    {
        $arrayResultados = null;

        $SQL = "SELECT P.nombre as NombrePartido, P.sigla as SiglaPartido, 
                    P.colorHex as ColorHex, SUM(PA.cantvotopartido) as VotosTotales
                FROM Partido as P, PartidoActaVotos as PA, ActaVotos as A 
                WHERE PA.idPartido = P.id and PA.idActaVotos = A.id 
                GROUP BY P.nombre, P.sigla, P.colorHex";

        $arrayPorcentajes = DB::select($SQL);

        $totalVotos = 0;        
        for ($i=0; $i < count($arrayPorcentajes); $i++) 
        { 
            $totalVotos += $arrayPorcentajes[$i]->VotosTotales;
        }

        for ($i=0; $i < count($arrayPorcentajes); $i++) 
        { 
            $arrayResultados[] = new ResultadoGrafica(
                $arrayPorcentajes[$i]->SiglaPartido,
                $arrayPorcentajes[$i]->ColorHex,
                round(($arrayPorcentajes[$i]->VotosTotales * 100) / $totalVotos),
                $arrayPorcentajes[$i]->VotosTotales
            );
        }

        //var_dump($arrayResultados);

        return View::make('graficaGeneral', compact('arrayResultados', 'totalVotos'))->render();
    }


    public function exportResultadosExcel() 
    {        
        return Excel::download(new ResultadosExport(), 'resultados.xlsx');
    }

    public function exportResultadosPDF() 
    {        
        $SQL = "SELECT P.nombre as NombrePartido, P.sigla as SiglaPartido, 
                    SUM(PA.cantvotopartido) as VotosTotales
                FROM Partido as P, PartidoActaVotos as PA, ActaVotos as A 
                WHERE PA.idPartido = P.id and PA.idActaVotos = A.id 
                GROUP BY P.nombre, P.sigla";

        $array = DB::select($SQL);

        //Solucion al error para Dompdf: Maximum execution time of 30 seconds exceeded
        set_time_limit(300); // Extends to 5 minutes.                                          

        $pdf = PDF::loadView('plantillaResultadosPDF', ['resultados' => $array]);
        $pdf->setPaper('A4', 'landscape');
        
        //return $pdf->download('resultados.pdf');    
        return $pdf->stream('resultados.pdf');
        
    }
}
