<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\departamento; //modelo
use App\Http\Requests\departamentoFormRequest;//request

//añadir siempre
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

//usa la bd
use DB;


class DepartamentoController extends Controller
{


    public function __construct()
    {

    }


    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $departamento = DB::table('Departamento as c')    
           // ->join('Partido as p', 'p.id','=','c.idPartido')
            ->where('c.nombre','LIKE','%'.$query.'%')
            ->orderBy('c.id','ASC')
            ->paginate(5);
            return view('departamento.index', ["departamento" => $departamento, "searchText" => $query]);
        }
    }


    public function create()
    {
     return view("departamento.create");
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
        return view("departamento.edit", ["departamento" => Departamento::findOrFail($id)]);
    }


    public function update(PrivilegioFormRequest $request, $id)
    {
    
        $departamento = Departamento::findOrFail($id);
        $departamento->nombre= $request->get('nombre');
     
        $departamento->update();
        return Redirect::to('departamento');
        
    }


    public function destroy($id)
    {
        
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();
        return Redirect::to('departamento');
        
    }
}






