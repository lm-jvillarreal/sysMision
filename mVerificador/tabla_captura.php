<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$codigo = $_POST['codigo'];
$almacen = $_POST['sucursal'];
//$anio = date("Y");
$anio = '2018';

$cadena = "SELECT
          mapeo.id,
          mapeo.cara,
          mapeo.zona,
          mapeo.mueble,
          (SELECT SUM(cantidad) FROM inv_captura WHERE id_mapeo = mapeo.id AND cod_producto = '$codigo'),
          captura.usuario,
          mapeo.id_sucursal,
          usuarios.nombre_usuario,
          detalle_mapeo.estante,
          detalle_mapeo.consecutivo_mueble,
          areas.nombre,
          CASE contador
          when 2 then 'Supervisado'
          WHEN 6 then 'Capturado'
          WHEN 9 THEN 'Directo'
          end
        FROM
          inv_captura captura
        INNER JOIN inv_mapeo mapeo ON mapeo.id = captura.id_mapeo
        INNER JOIN areas ON areas.id = mapeo.id_area
        INNER JOIN usuarios ON usuarios.id = captura.usuario
        INNER JOIN inv_detalle_mapeo detalle_mapeo ON detalle_mapeo.id_mapeo = mapeo.id
        WHERE
          cod_producto = '$codigo' 
        AND mapeo.fecha_conteo = '$fecha_inicial'
        AND mapeo.id_sucursal = '$almacen'
        GROUP BY mapeo.id";
                    //echo "$cadena";
    $exCadena = mysqli_query($conexion, $cadena);
    


$cuerpo ="";

while ($row = mysqli_fetch_row($exCadena)) {
	$renglon = "
		{
    \"area\": \"$row[10]\",
		\"zona\": \"$row[2]\",
		\"mueble\": \"$row[3]\",
		\"cara\": \"$row[1]\",
		\"estante\": \"$row[8]\",
    \"consecutivo\": \"$row[9]\",
    \"cantidad\": \"$row[4]\",
    \"usuario\": \"$row[7]\",
    \"tipo\": \"$row[11]\"
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