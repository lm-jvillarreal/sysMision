<?php 
    include 'conexion_servidor.php';
    $fecha_inicial = $_GET['fecha_inicial'];
    $fecha_final = $_GET['fecha_final'];
 ?>
<div id="chartContainer"></div>
        <link href="/assets/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/style.css" rel="stylesheet">
        <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
                <script src="/assets/js/jquery-1.12.4.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
$qry = "SELECT DISTINCT
            US.USUC_NOMBRE,
            (
                SELECT
                    COUNT (ALMN_ALMACEN)
                FROM
                    INV_MOVIMIENTOS
                WHERE
                    MOVD_FECHAAFECTACION >= TRUNC (
                        TO_DATE (
                            '$fecha_inicial',
                            'YYYY/MM/DD'
                        )
                    )
                AND MOVD_FECHAAFECTACION < TRUNC (
                    TO_DATE (
                        '$fecha_final',
                        'YYYY/MM/DD'
                    )
                ) + 1
                AND (
                    MODC_TIPOMOV = 'ENTCOC'
                    OR MODC_TIPOMOV = 'ENTSOC'
                )
                AND MOVN_USUARIOREALIZAMOV = MO.MOVN_USUARIOREALIZAMOV
            )
        FROM
            INV_MOVIMIENTOS MO
        INNER JOIN CTB_USUARIO US ON US.USUS_USUARIO = MO.MOVN_USUARIOREALIZAMOV
        WHERE
            MOVD_FECHAAFECTACION >= TRUNC (
                TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
            )
        AND MOVD_FECHAAFECTACION < TRUNC (
            TO_DATE ('$fecha_final', 'YYYY/MM/DD')
        ) + 1
        AND (
            MODC_TIPOMOV = 'ENTCOC'
            OR MODC_TIPOMOV = 'ENTSOC'
        )
        AND (
            MOVN_USUARIOREALIZAMOV = '3013'
            OR MOVN_USUARIOREALIZAMOV = '3063'
            OR MOVN_USUARIOREALIZAMOV = '3064'
            OR MOVN_USUARIOREALIZAMOV = '3102'
            OR MOVN_USUARIOREALIZAMOV = '3114'
            OR MOVN_USUARIOREALIZAMOV = '3103'
            OR MOVN_USUARIOREALIZAMOV = '3057'
            OR MOVN_USUARIOREALIZAMOV = '3232'
            OR MOVN_USUARIOREALIZAMOV = '3206'
        )";
    $st = oci_parse($conexion_central, $qry);
    oci_execute($st);
    $dataPoints = array();
    while ($row = oci_fetch_row($st)) {
        $point = array("y" => $row[1] , "label" => $row[0]);
        array_push($dataPoints, $point);
    }

?>

<script type="text/javascript">

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Gráfica de entradas por usuario"
            },
            data: [
            {
                type: "column",                
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });
</script>

