<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Paquete;
use App\Error;
use App\ResultadoFoto;
use App\ResultadoGrafica;
use DB;
use Throwable;

class APIController extends Controller
{
    public function login(Request $request) 
    {
        $login = $request->input("login");
        //encriptar Password con bcrypt()
        $password = $request->input("password");        
        $password = md5($password);        

        $paquete = new Paquete();

        try {
            //idRol: 1 => Delegado de mesa
            $SQL = "SELECT *
                    FROM Usuario 
                    WHERE (login = '$login' OR correo = '$login')
                        and password = '$password' 
                        and idRol = 1";
            $array = DB::select($SQL);                    
            
            if ($array !== null && count($array) > 0) {
                $paquete->error = 0;
                $paquete->message = "Usuario encontrado";
                $paquete->values = $array[0];                    

                return response()->json(
                    $paquete
                );
            }        

            $paquete->error = 1;
            $paquete->message = "Usuario o Contraseña incorrectos";
            $paquete->values = null;
            return response()->json(
                $paquete
            );
            
        } catch (\Throwable $th) {
            $paquete->error = 2;
            $paquete->message = "Ocurrio un error. Porfavor intente de nuevo";
            $paquete->values = $th;        
        }

        return response()->json(
            $paquete
        );
    }


    public function verificarNumeroMesa(Request $request)
    {
        $numero = $request->input("numero");
        $idUsuario = $request->input("idUsuario");

        $paquete = new Paquete();

        try {
            //Comprobar si el delegado esta asignado a esa mesa con dicho numero
            $sql = "SELECT * 
                    FROM Mesa, Usuario
                    WHERE Usuario.idMesa = Mesa.id and
                        Mesa.numero = $numero and
                        Usuario.id = $idUsuario";
            $array = DB::select($sql);
            
            if ($array !== null && count($array) > 0) {                       
                //Comprobar si ya envio la imagen para el Acta de Votos    
                $sql = "SELECT ActaVotos.imagen, ActaVotos.hora, ActaVotos.fecha, 
                            ActaVotos.cantTotal, ActaVotos.votosNulos, ActaVotos.votosBlanco  
                        FROM ActaVotos, Usuario
                        WHERE ActaVotos.idUsuario = Usuario.id and
                            Usuario.id = $idUsuario";
                $array = DB::select($sql);

                if ($array !== null && count($array) > 0) {
                    //Ya se envio la imagen
                    //Mostrar la imagen
                    $paquete->error = 0;
                    $paquete->message = "Usted ya envio la imagen para esta mesa";
                    $paquete->values = $array[0];                     
                } else {
                    //Aun no se envio la imagen      
                    //Mostrar informacion de la mesa              
                    $sql = "SELECT Mesa.numero, Departamento.nombre as departamento, Provincia.nombre as provincia, 
                                Localidad.nombre as localidad, Recinto.nombre as recinto
                            FROM Departamento, Provincia, Localidad, Recinto, Mesa, Usuario
                            WHERE Departamento.id = Provincia.idDepartamento and
                                Provincia.id = Localidad.idProvincia and                               
                                Localidad.id = Recinto.idLocalidad and
                                Mesa.idRecinto = Recinto.id and
                                Usuario.idMesa = Mesa.id and
                                Usuario.id = " . $idUsuario;
                    $array = DB::select($sql);
                   
                    $paquete->error = 3;
                    $paquete->message = "Imagen no enviada, Confirme la ubicacion de la mesa";
                    $paquete->values = $array[0];
                }                                               
            } else {               
                $paquete->error = 2;
                $paquete->message = "Usted no es el delegado asignado a esta mesa";
                $paquete->values = null;
            }
            
            return response()->json(
                $paquete
            );   

        } catch (\Throwable $th) {
            $paquete->error = 1;
            $paquete->message = "Ocurrio un error. Porfavor intente de nuevo";
            $paquete->values = $th;        
        }

        return response()->json(
            $paquete
        );
    }


    public function procesarIdPartidos($arrayVotos, $idActaVotos)
    {
        $SQL = "SELECT id, sigla 
                FROM Partido";
        $query = DB::select($SQL);

        $array = [];
        
        //indice 0 al 2 son los VotosTotales, VotosNulos y VotosBlancos
        for ($i=3; $i < count($arrayVotos); $i++) { 
            for ($j=0; $j < count($query); $j++) { 
                if (strpos($query[$j]["sigla"], $arrayVotos[$i]["sigla"]) ) {                    
                    $array[] = ['idPartido' => $query[$j]["id"], 'idActaVotos' => $idActaVotos, 'cantVotosPartido' => $arrayVotos[$i]["votos"]];
                    break;
                }
            }
        }

        return $array;
    }
        
    public function procesarTextoImagen(Request $request)
    {
        $idUsuario = $request->input("idUsuario");
        $arrayVotos = json_decode($request->input("arrayVotos"), true);
        $urlImagen = $request->input("urlImagen");    

        $paquete = new Paquete();        

        try {        
            $idActaVotos = DB::table('ActaVotos')->insertGetId(
                ['cantTotal' => $arrayVotos[0]["votos"],                
                'votosBlanco' => $arrayVotos[1]["votos"],
                'votosNulos' => $arrayVotos[2]["votos"],
                'fecha' => date('Y-m-d'), 
                'hora' => date('H:i:s'),
                'imagen' => $urlImagen,
                'idUsuario' => $idUsuario,]               
            );


            //Buscar los ids de cada partido 
            //$array = $this->procesarIdPartidos($arrayVotos, $idActaVotos);
            $SQL = "SELECT id, sigla 
                FROM Partido";
            $query = DB::select($SQL);
            $array = [];                                   
            //indice 0 al 2 son los VotosTotales, VotosNulos y VotosBlancos
            for ($i=3; $i < count($arrayVotos); $i++) { 
                for ($j=0; $j < count($query); $j++) { 
                    if ($arrayVotos[$i]["sigla"] == $query[$j]->sigla) {                    
                        $array[] = ['idPartido' => $query[$j]->id, 'idActaVotos' => $idActaVotos, 'cantvotopartido' => $arrayVotos[$i]["votos"]];
                        break;
                    }
                }
            }


            if ($idActaVotos !== null) {
                DB::table('PartidoActaVotos')->insert(
                    $array
                );                    

                $paquete->error = 0;
                $paquete->message = "Datos procesados correctamente";
                $paquete->values = null;

                return response()->json(
                    $paquete
                );
            } 
                    
            $paquete->error = 1;
            $paquete->message = "No se puede procesar el texto porfavor intente de nuevo";
            $paquete->values = null;
            return response()->json(
                $paquete
            );
            
        } catch (\Throwable $th) {
            $paquete->error = 1;
            $paquete->message = "Ocurrio un error. Porfavor intente de nuevo";
            $paquete->values = $th->getMessage();      
            return response()->json(
                $paquete
            );  
        }        
    }


    /*
    public $arrayVotos = null;
    public $arraySiglas = null;
    public $arrayResultados = null;
    public function procesarTextoImagen2(Request $request)
    {
        $texto = $request->input("texto");
        $arrayTexto = explode(PHP_EOL, $texto);

        $paquete = new Paquete();

        try {
            //Procesamiento del texto
            

            //var_dump($arrayTexto);
            
            for ($i=0; $i < count($arrayTexto); $i++) 
            { 
                if (is_numeric($arrayTexto[$i])) {
                    $arrayVotos[] = abs($arrayTexto[$i]);
                } else {
                    //Verifica que NO contenga las 'ZZZ'
                    if (strpos($arrayTexto[$i], 'Z') === false) {
                        $arraySiglas[] = $arrayTexto[$i];
                    }                    
                }                            
            }


            //var_dump($arrayVotos);
            //var_dump($arraySiglas);


            
            $arrayPartidos = DB::select("SELECT * FROM Partido");

            for ($i=0; $i < count($arraySiglas); $i++) 
            { 
                if ($this->verificarExistePartido($arraySiglas[$i], $arrayPartidos, $i)) {
                    # code...
                } else {
                    # code...
                }
                
            }

            var_dump($this->arrayResultados);
            

            $paquete->error = 1;
            $paquete->message = "No se puede procesar el texto porfavor intente de nuevo";
            $paquete->values = null;
            return response()->json(
                $paquete
            );
            
        } catch (Exception $th) {
            $paquete->error = 2;
            $paquete->message = "Ocurrio un error. Porfavor intente de nuevo";
            $paquete->values = null;        
        }

        return response()->json(
            $paquete
        );
    }

    public function verificarExistePartido($sigla, $arrayPartidos, $i)
    {
        for ($j=0; $j < count($arrayPartidos); $j++) { 
            echo $arrayPartidos[$j]->sigla;
            echo "---";
            echo $sigla;
            echo "-------------------------";
            if (strpos( $sigla, $arrayPartidos[$j]->sigla) !== false) {
                $this->arrayResultados = new ResultadoFoto(
                    $arrayPartidos[$j]->id,
                    $this->arrayVotos[$i]
                );
                return true;
            }
        }
        return false;
    }

    public function procesarTextoImagen(Request $request)
    {
        $arrayVotos = $request->input("texto");
        $image = $request->input("imagen");  // your base64 encoded

        $paquete = new Paquete();

        try {

            //Procesando y guardando la imagen
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put(storage_path(). '/' . $imageName, base64_decode($image));

            
            $idActaVotos = DB::table('ActaVotos')->insertGetId(
                ['idMesa' => 1,
                'fecha' => date('Y-m-d'), 
                'hora' => date('H:i:s')]               
            );

            if ($idActaVotos !== null) {
                DB::table('PartidoActaVotos')->insert([
                    ['idPartido' => 1, 'idActaVotos' => $idActaVotos, 'cantVotos' => 26],
                    ['idPartido' => 2, 'idActaVotos' => $idActaVotos, 'cantVotos' => 28],
                    ['idPartido' => 3, 'idActaVotos' => $idActaVotos, 'cantVotos' => 26],
                    ['idPartido' => 4, 'idActaVotos' => $idActaVotos, 'cantVotos' => 16],
                    ['idPartido' => 5, 'idActaVotos' => $idActaVotos, 'cantVotos' => 19],
                    ['idPartido' => 6, 'idActaVotos' => $idActaVotos, 'cantVotos' => 15],
                    ['idPartido' => 7, 'idActaVotos' => $idActaVotos, 'cantVotos' => 15],
                    ['idPartido' => 8, 'idActaVotos' => $idActaVotos, 'cantVotos' => 13],
                    ['idPartido' => 9, 'idActaVotos' => $idActaVotos, 'cantVotos' => 25]
                ]);
    
                DB::table('ActaVotos')
                ->where('id', $idActaVotos)
                ->update(['cantTotal' => 183, 
                        'votosNulos' => 10,
                        'votosBlancos' => 0]);

                $paquete->error = 0;
                $paquete->message = "Datos procesados correctamente";
                $paquete->values = null;
                return response()->json(
                    $paquete
                );
            } 
                    
            $paquete->error = 1;
            $paquete->message = "No se puede procesar el texto porfavor intente de nuevo";
            $paquete->values = null;
            return response()->json(
                $paquete
            );
            
        } catch (Exception $th) {
            $paquete->error = 2;
            $paquete->message = "Ocurrio un error. Porfavor intente de nuevo";
            $paquete->values = null;      
            return response()->json(
                $paquete
            );  
        }        
    }
    */

}
