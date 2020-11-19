<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use DB;


class ResultadosExport implements FromView
{
    public function view(): View
    {
        $SQL = "SELECT P.nombre as NombrePartido, P.sigla as SiglaPartido, 
                    SUM(PA.cantvotopartido) as VotosTotales
                FROM Partido as P, PartidoActaVotos as PA, ActaVotos as A 
                WHERE PA.idPartido = P.id and PA.idActaVotos = A.id 
                GROUP BY P.nombre, P.sigla, P.colorHex";

        $array = DB::select($SQL);

        return view('exportResultadosExcel', [
            'resultados' => $array
        ]);
    }
}
