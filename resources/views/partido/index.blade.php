@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Partidos Politicos <a href="partido/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('partido.search')

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>ID</th>
                    <th>NOMBRE</th>
                    <th>SIGLA</th>
					<th>COLOR</th>
					<th>Accion</th>				
				</thead>

				
               @foreach ($partido as $emp)
				<tr>
					<td>{{ $emp->id}}</td>
					<td>{{ $emp->nombre}}</td>
					<td>{{ $emp->sigla}}</td>
					<td>{{ $emp->color}}</td>
					<td>
						<a href="{{URL::action('PartidoController@edit', $emp->id)}}"><button class="btn btn-info">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{$emp->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
					
				</tr>

				@endforeach
			</table>
		</div>
		{{$partido->render()}}
	</div>
</div>

@endsection