<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\recinto; //modelo
use App\Http\Requests\recintoFormRequest;//request

//añadir siempre
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

//usa la bd
use DB;


class RecintoController extends Controller
{
  
    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $recinto = DB::table('Recinto as r')    
            ->join('Localidad as l', 'l.id','=','r.idLocalidad')
            ->where('r.nombre','LIKE','%'.$query.'%')
            ->orderBy('r.id','ASC')
            ->paginate(5);
            return view('recinto.index', ["recinto" => $recinto, "searchText" => $query]);
        }
    }


    public function create()
    {
     return view("recinto.create");
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
        return view("recinto.edit", ["recinto" => Recinto::findOrFail($id)]);
    }


    public function update(PrivilegioFormRequest $request, $id)
    {
    
        $recinto = Recinto::findOrFail($id);
        $recinto->nombre= $request->get('nombre');
     
        $recinto->update();
        return Redirect::to('recinto');
        
    }


    public function destroy($id)
    {
        
        $candidato = Candidato::findOrFail($id);
        $candidato->delete();
        return Redirect::to('candidato');
        
    }
}






