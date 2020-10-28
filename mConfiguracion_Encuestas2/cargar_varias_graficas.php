<?php
    
    include '../global_seguridad/verificar_sesion.php';

	$id_encuesta = $_POST['id_encuesta'];
	$fecha1      = $_POST['fecha1'];
	$fecha2      = $_POST['fecha2'];
	$pregunta    = $_POST['pregunta'];

	$filtro = ($pregunta == "")?"":" AND n_preguntas.id = '$pregunta'";


    $cadena = mysqli_query($conexion,"SELECT id,pregunta
               FROM n_preguntas
               WHERE folio = '$id_encuesta'
               ".$filtro."
               AND tipo = '1'");
    $numero = 1;
    while($row = mysqli_fetch_array($cadena)){

        $cadena2 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                FROM n_resultados                
                WHERE respuesta = 'si'
                AND id_pregunta = '$row[0]'
                AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");  
        $cantidad_si = mysqli_num_rows($cadena2);
        $cantidad_si = ($cantidad_si == "")?0:$cantidad_si;

        $cadena3 = mysqli_query($conexion,"SELECT n_resultados.respuesta
                FROM n_resultados                
                WHERE respuesta = 'no'
                AND id_pregunta = '$row[0]'
                AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)");  
        $cantidad_no = mysqli_num_rows($cadena3);
        $cantidad_no = ($cantidad_no == "")?0:$cantidad_no;
        $total = $cantidad_no + $cantidad_si;
?>
<div class="col-md-6">
	<div id="container<?php echo $numero?>" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
	<center>
		<label>Cantidad de Respuestas con No: <?php echo $cantidad_no?> / <?php echo $total?> </label>
		<br>
		<label>Cantidad de Respuestas con Si: <?php echo $cantidad_si?> / <?php echo $total?> </label>
	</center>
</div>
    <script>
        Highcharts.chart('container<?php echo $numero?>', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: '<?php echo $row[1]?>'
          },
          tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Si',
            colorByPoint: true,
            data: [{
              name: 'Respuesta No',
              y: <?php echo $cantidad_si;?>,
              color: '#f57f17',
              sliced: true,
              selected: true
            },{
              name: 'Respuesta Si',
              color: '#434348',
              y: <?php echo $cantidad_no;?>
            }]
          }]
        });   //Grafica de Barras
    </script>
<?php
    $numero ++;
    }
?>