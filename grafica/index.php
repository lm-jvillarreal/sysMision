<?php
include '../global_settings/conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
	<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>

	<script>
	$(function () {
	    // Create the chart
	Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Desglose de Aportaciones, Diciembre de 2018'
    },
    subtitle: {
        text: 'Registro por Comprador'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total de aportaciones  ($)'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '$ {point.y:,.2f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.2f}$</b> del total<br/>'
    },

    "series": [
        {
            "name": "Compradores",
            "colorByPoint": true,
            "data":[<?php include 'datos_grafica.php'; ?>]
        }
    ]
});
	});
</script>
</body>
</html>