<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\provincia; //modelo
    use App\Http\Requests\provinciaFormRequest;//request
    
    //añadir siempre
    use App\Http\Requests;
    use Illuminate\Support\Facades\Redirect;
    
    //usa la bd
    use DB;
class ProvinciaController extends Controller
{
    
   
    
        public function __construct()
        {
    
        }
    
    
        public function index(Request $request)
        {
            if ($request)
            {
                $query = trim($request->get('searchText'));
                $provincia = DB::table('Provincia as c')    
                ->join('Departamento as p', 'p.id','=','c.idDepartamento')
                ->where('c.nombre','LIKE','%'.$query.'%')
                ->orderBy('c.id','ASC')
                ->paginate(5);
                return view('provincia.index', ["provincia" => $provincia, "searchText" => $query]);
            }
        }
    
    
        public function create()
        {
         return view("provincia.create");
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
            return view("provincia.edit", ["provincia" => Provincia::findOrFail($id)]);
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
    
    
    
    
    
    
    
    
    
    
    
    

