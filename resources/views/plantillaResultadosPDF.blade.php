<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resultados Elecciones 2020</title>
    <style>              
        div.listadoContenedor{
			text-align: center;                     
            padding: 25px;
            margin: 15px;
            border-top: 1px solid black;
            border-bottom: 1px solid black;            
        }  
		table { 
			margin: auto; 
		}      
        div.listadoContenedor tr th {
            text-align: center;
			position: relative;
            padding: 5px;			
            background-color: deepskyblue;
        }
        div.listadoContenedor tr td{			
			text-align: center;
            position: relative;
            padding: 5px;           
        }     
        body
        {            
			padding: 15px;
            border:3px solid gray;
			/*background-color: cadetblue;*/
        }        
        .imgLogo
        { 
            width: 150px;
            
        }        
        div.reporteContact{
            position: absolute;
            top: 0px;
            left: 10px;           
        }        		
		.column {
			float: left;
			width: 33.33%;
			text-align: center;
		}		
		/* Clear floats after the columns */
		.row:after {		  
		  display: table;
		  clear: both;
		}
    </style>
</head>
<body>     
	<div class="row">	
		<div class="column" style="text-align: left;">	
            <img class="imgLogo" src="logo/bolivia.png">
		</div>				
		<div class="column">
			<h1>RESULTADOS ELECCIONES 2020</h1>
			<h3>{{date('d-m-Y')}} {{date('H:i:s')}}</h3>
		</div>		
		<div class="column" style="text-align: right;">
			<img class="imgLogo" src="logo/elecciones2020.jpg">
		</div>					
	</div>	

	<div class="listadoContenedor" style="clear: both;">    
		<table>
			<thead>
				<tr>                      
					<th>Nombre Partido</th>	
					<th>Sigla Partido</th>
					<th>Votos Totales</th>													
				</tr>            				
			</thead>
			<tbody>
				@foreach ($resultados as $res)					
				<tr>         
					<td>{{ $res->NombrePartido }}</td>
					<td>{{ $res->SiglaPartido }}</td>
					<td>{{ $res->VotosTotales }}</td>																							
				</tr>
				@endforeach        								
			</tbody>                   
		</table>
	</div>

</body>
