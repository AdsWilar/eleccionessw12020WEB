<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mesa; //modelo
use App\Http\Requests\mesaFormRequest;//request

//añadir siempre
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

//usa la bd
use DB;

class MesaController extends Controller
{

    public function __construct()
    {

    }


    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $mesa = DB::table('Mesa as m')    
            ->join('Encargado as e', 'e.id','=','m.idEncargado')
            ->join('Recinto as r', 'r.id','=','m.idRecinto')
            ->where('m.id','LIKE','%'.$query.'%')
            ->orderBy('m.id','ASC')
            ->paginate(5);
            return view('mesa.index', ["mesa" => $mesa, "searchText" => $query]);
        }
    }


    public function create()
    {
     return view("mesa.create");
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
        return view("mesa.edit", ["mesa" => Mesa::findOrFail($id)]);
    }


    public function update(PrivilegioFormRequest $request, $id)
    {
    
        $candidato = Candidato::findOrFail($id);
        $candidato->nombre= $request->get('nombre');
     
        $candidato->update();
        return Redirect::to('candidato');
        
    }


    public function destroy($id)
    {
        
        $candidato = Candidato::findOrFail($id);
        $candidato->delete();
        return Redirect::to('candidato');
        
    }
}






