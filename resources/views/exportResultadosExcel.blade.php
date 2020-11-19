<table>
    <thead>
    <tr>
        <th>Nombre del Partido</th>
        <th>Sigla del Partido</th>
        <th>Votos Totales</th>
    </tr>
    </thead>
    <tbody>
    @foreach($resultados as $res)
        <tr>
            <td>{{ $res->NombrePartido }}</td>
            <td>{{ $res->SiglaPartido }}</td>
            <td>{{ $res->VotosTotales }}</td>
        </tr>
    @endforeach
    </tbody>
</table>