@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Acta de Votos
       

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>ID</th>
                    <th>CANTIDAD TOTAL</th>
                    <th>VOTOS NULOS</th>
                    <th>VOTOS BANCOS</th>
                    <th>FEHCA</th>
                    <th>HORA</th>
					<th>IDMESA</th>
				</thead>

				
               @foreach ($actavotos as $emp)
				<tr>
					<td>{{ $emp->id}}</td>
					<td>{{ $emp->cantTotal}}</td>
					<td>{{ $emp->votosNulos}}</td>
                    <td>{{ $emp->votosBlancos}}</td>
                    <td>{{ $emp->fecha}}</td>
					<td>{{ $emp->hora}}</td>
					<td>{{ $emp->idMesa}}</td>
				
				</tr>

				@endforeach
			</table>
		</div>
		{{$actavotos->render()}}
	</div>
</div>

@endsection