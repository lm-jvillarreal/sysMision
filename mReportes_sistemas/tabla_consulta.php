<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
// $codigo = $_POST['codigo'];
// $almacen = $_POST['sucursal'];
$fecha_i=str_replace("-","",$fecha_inicial);
$fecha_f=str_replace("-","",$fecha_final);
//$anio = date("Y");
$anio = '2018';

$cadena = "SELECT
                id,
                referencia,
            CASE
                tipo 
                WHEN 1  THEN 'IMMEX' 
                WHEN 2 THEN 'DIESTEL' 
                END,
            CONCAT(fecha1,' al ',fecha2)
            FROM
                referencias_recargas 
            WHERE
                fecha BETWEEN '$fecha_inicial' 
                AND '$fecha_final'";
                //echo "$cadena";
$exCadena = mysqli_query($conexion, $cadena);


$cuerpo ="";

while ($row_gastos = mysqli_fetch_array($exCadena)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>Detalles</a></center>";
    $cantidad = "<input type='text' class='form-control' name='cantidad[]' value='0'>";	
    $codigo = "<input type='text' class='form-control' name='codigo[]' value='$row_gastos[0]' readonly>"; 
    // $total = $row_gastos[2] + $row_gastos[3]+ $row_gastos[4] + $row_gastos[5];
    $renglon = "
		{
		\"folio\": \"$row_gastos[0]\",
		\"referencia\": \"$row_gastos[1]\",
		\"tipo\": \"$row_gastos[2]\",
        \"Rango\": \"$row_gastos[3]\",
		\"detalle\": \"$link_detalle\"
        
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>