<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\partido; //modelo
use App\Http\Requests\partidoFormRequest;//request
//añadir siempre
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

//usa la bd
use DB;

class PartidoController extends Controller
{
    

    public function __construct()
    {

    }


    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $partido = DB::table('Partido as p')    
           // ->join('users as U', 'U.id','=','E.idUsers')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->orderBy('p.id','ASC')
            ->paginate(5);
            return view('partido.index', ["partido" => $partido, "searchText" => $query]);
        }
    }


    public function create()
    {
     return view("partido.create");
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
        return view("partido.edit", ["partido" => Partido::findOrFail($id)]);
    }


    public function update(PrivilegioFormRequest $request, $id)
    {
    
        $privilegio = Privilegio::findOrFail($id);
        $privilegio->NOMBRE= $request->get('nombre');
     
        $privilegio->update();
        return Redirect::to('privilegio');
        
    }


    public function destroy($id)
    {
        
        $privilegio = Privilegio::findOrFail($id);
        $privilegio->delete();
        return Redirect::to('privilegio');
        
    }
}


