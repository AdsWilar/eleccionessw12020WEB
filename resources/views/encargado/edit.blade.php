@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Datos de los Encargados: {{ $encargado->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($encargado, ['method'=>'PATCH','route'=>['encargado.update', $encargado->id]])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$encargado->nombre}}" placeholder="Nombre...">
            </div>
            
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<!--<button class="btn btn-danger" type="reset">Cancelar</button>-->
				<a class="btn btn-danger" href="{{ url('encargado') }}">Cancelar</a>
            </div>			
			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection
