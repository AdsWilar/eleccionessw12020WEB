@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Candidatos <a href="mesa/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('mesa.search')

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>ID</th>
                    <th>NUMERO</th>
                    <th>DESCRIPCION</th>
                    <th>ESTADO</th>
                    <th>IDENCARGADO</th>
                    <th>IDRECINTO</th>
					<th>Accion</th>				
				</thead>

				
               @foreach ($mesa as $emp)
				<tr>
					<td>{{ $emp->id}}</td>
					<td>{{ $emp->numero}}</td>
					<td>{{ $emp->descripcion}}</td>
                    <td>{{ $emp->estado}}</td>
                    <td>{{ $emp->idEncargado}}</td>
					<td>{{ $emp->idRecinto}}</td>
					<td>
						<a href="{{URL::action('MesaController@edit', $emp->id)}}"><button class="btn btn-info">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{$emp->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
					
				</tr>

				@endforeach
			</table>
		</div>
		{{$mesa->render()}}
	</div>
</div>

@endsection