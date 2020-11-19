@extends ('layouts.admin')

@section ('contenido')

    <div class="row">

      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><h2 style="text-align:center;">RESULTADOS EN BOCA DE URNA</h2></h3>
          <div class="small-box bg-aqua">
            <div class="inner">
              <h4>Total de votos contabilizados: </h4>
              <h3>{!! $totalVotos !!}</h3>
              <p>Datos actualizados a {!! date('H:i:s') !!} del {!! date('d/m/Y') !!}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">              
            </a>
          </div>         

          <a class="btn btn-success" href="{{ url('exportResultadosExcel') }}">EXPORTAR A EXCEL</a>

          <a class="btn btn-danger" href="{{ url('exportResultadosPDF') }}">EXPORTAR A PDF</a>

        </div>
      </div>

      
          
      <div class="col-md-6">        
        <!-- DONUT CHART -->
        <div class="box box-success">              
          <div class="box-header with-border">
            <h3 class="box-title">Grafica de porcentajes %</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <canvas id="pieChart" style="height:250px"></canvas>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->                                    
      </div>
      <!-- /.col (RIGHT) -->

      <!-- /.col (LEFT) -->
      <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafica de barras</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->      
      </div>  

      
            
    </div>
    <!-- /.row -->

@endsection


@push('scripts')
    <!-- page script -->
    <script>

    var arrayResultados = {!! json_encode($arrayResultados) !!};
    console.log(arrayResultados);

    $(function () {
        /* ChartJS
        * -------
        * Here we will create a few charts using ChartJS
        */      

        //-------------
        //- GRAFICA DE TORTA -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieChart       = new Chart(pieChartCanvas)      

        var PieData = new Array();
        for (var i = 0; i < arrayResultados.length; i++) {
          PieData.push({
              value    : arrayResultados[i]["porcentaje"],
              color    : arrayResultados[i]["colorHex"],
              highlight: arrayResultados[i]["colorHex"],
              label    : arrayResultados[i]["siglaPartido"]
          });
        }

        var pieOptions     = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke    : true,
          //String - The colour of each segment stroke
          segmentStrokeColor   : '#fff',
          //Number - The width of each segment stroke
          segmentStrokeWidth   : 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps       : 100,
          //String - Animation easing effect
          animationEasing      : 'easeOutBounce',
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate        : true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale         : false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive           : true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio  : true,
          //String - A legend template
          legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions)


        //-------------
        //- GRAFICA DE BARRAS -
        //-------------

        var arrayLabels = new Array();
        for (var i = 0; i < arrayResultados.length; i++) {
          arrayLabels.push(arrayResultados[i]["siglaPartido"]);
        }

        var arrayVotos = new Array();
        for (var i = 0; i < arrayResultados.length; i++) {
          arrayVotos.push(parseInt(arrayResultados[i]["votos"]));
        }

        var areaChartData = {
          labels  : arrayLabels,
          datasets: [
              {
              label               : 'Electronics',
              fillColor           : 'rgba(60,141,188,0.9)',
              strokeColor         : 'rgba(60,141,188,0.8)',
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : arrayVotos
              }        
          ]
        }

        var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
        var barChart                         = new Chart(barChartCanvas)
        var barChartData                     = areaChartData
        //barChartData.datasets[1].fillColor   = '#00a65a'
        //barChartData.datasets[1].strokeColor = '#00a65a'
        //barChartData.datasets[1].pointColor  = '#00a65a'
        var barChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true
        }

        barChartOptions.datasetFill = false
        barChart.Bar(barChartData, barChartOptions)
                   
        
    })
    </script>

@endpush