@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Recinto <a href="recinto/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('recinto.search')

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>ID</th>
                    <th>NOMBRE</th>
                    <th>CODIGO</th>
                    <th>DIRECCION</th>
                    <th>LATITUD</th>
                    <th>LONGITUD</th>
					<th>IDLOCALIDAD</th>
					<th>Accion</th>				
				</thead>

				
               @foreach ($recinto as $emp)
				<tr>
					<td>{{ $emp->id}}</td>
					<td>{{ $emp->nombre}}</td>
					<td>{{ $emp->codigo}}</td>
                    <td>{{ $emp->direccion}}</td>
                    <td>{{ $emp->lat}}</td>
					<td>{{ $emp->lon}}</td>
					<td>{{ $emp->idLocalidad}}</td>
					<td>
						<a href="{{URL::action('RecintoController@edit', $emp->id)}}"><button class="btn btn-info">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{$emp->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
					
				</tr>

				@endforeach
			</table>
		</div>
		{{$recinto->render()}}
	</div>
</div>

@endsection