@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Encargados<a href="encargado/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('encargado.search')

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>ID</th>
                    <th>LOGIN</th>
                    <th>PASSWORD</th>
                    <th>CORREO</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>CI</th>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>TELEFONO</th>
					<th>DIRECCION</th>
					<th>Accion</th>				
				</thead>

				
               @foreach ($encargado as $emp)
				<tr>
                    <td>{{ $emp->id}}</td>
                    <td>{{ $emp->login}}</td>
                    <td>{{ $emp->password}}</td>
                    <td>{{ $emp->correo}}</td>
					<td>{{ $emp->nombre}}</td>
					<td>{{ $emp->apellido}}</td>
                    <td>{{ $emp->ci}}</td>
                    <td>{{ $emp->fechaNac}}</td>
					<td>{{ $emp->telefono}}</td>
					<td>{{ $emp->direccion}}</td>
					<td>
						<a href="{{URL::action('EncargadoController@edit', $emp->id)}}"><button class="btn btn-info">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{$emp->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
					
				</tr>

				@endforeach
			</table>
		</div>
		{{$encargado->render()}}
	</div>
</div>

@endsection