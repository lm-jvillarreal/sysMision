<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$artc_articulo = $_POST['articulo'];

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_detalle = "SELECT cve_articulo, 
                          descripcion_articulo, 
                          sucursal, 
                          DATE_FORMAT(fecha_captura,'%d/%m/%Y %H:%i:%s') as fecha, 
                          (SELECT nombre_usuario FROM usuarios WHERE id=faltantes_pasven.usuario_captura) as captura 
                    FROM faltantes_pasven
                    WHERE cve_articulo='$artc_articulo'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
	$renglon = "
	{
		\"articulo\": \"$row_detalle[0]\",
		\"descripcion\": \"$row_detalle[1]\",
		\"sucursal\": \"$row_detalle[2]\",
    \"fecha\": \"$row_detalle[3]\",
    \"usuario\": \"$row_detalle[4]\"
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>