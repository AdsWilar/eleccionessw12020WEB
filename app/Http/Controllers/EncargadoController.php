<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\encargado; //modelo
use App\Http\Requests\encargadoFormRequest;//request

//añadir siempre
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

//usa la bd
use DB;

class EncargadoController extends Controller
{
   
    
        public function __construct()
        {
    
        }
    
    
        public function index(Request $request)
        {
            if ($request)
            {
                $query = trim($request->get('searchText'));
                $encargado = DB::table('Encargado as c')    
            //    ->join('Partido as p', 'p.id','=','c.idPartido')
                ->where('c.nombre','LIKE','%'.$query.'%')
                ->orderBy('c.id','ASC')
                ->paginate(5);
                return view('encargado.index', ["encargado" => $encargado, "searchText" => $query]);
            }
        }
    
    
        public function create()
        {
         return view("encargado.create");
        }
    
    
       /* public function store (PrivilegioFormRequest $request)
        {
            $privilegio = new Privilegio;
            $privilegio->NOMBRE = trim($request->get('nombre'));
            $privilegio->save();
    
            return Redirect::to('privilegio'); 
        }*/
    
    
      /*  public function show($id)
        {
            //return view("cliente.zona.show", ["zona" => Zona::findOrFail($id)]);
        }*/
    
    
        public function edit($id)
        {
            return view("encargado.edit", ["encargado" => Encargado::findOrFail($id)]);
        }
    
    
        public function update(PrivilegioFormRequest $request, $id)
        {
        
            $encargado = Encargado::findOrFail($id);
            $encargado->NOMBRnombreE= $request->get('nombre');
         
            $encargado->update();
            return Redirect::to('encargado');
            
        }
    
    
        public function destroy($id)
        {
            
            $encargado = Encargado::findOrFail($id);
            $encargado->delete();
            return Redirect::to('encargado');
            
        }
    }
    
    
    
    
    

