<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$anio = date("Y");
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$solo_suc = ($solo_sucursal == '1') ? " AND d.sucursal='$id_sede'" : "";

$cadena_dispersion = "SELECT 
                        d.id, 
                        s.nombre, 
                        d.folio_inicial, 
                        d.folio_final, 
                        d.cant_blocks, 
                        d.porcentaje, 
                        d.activo,
                        DATE_FORMAT(d.fecha, '%d/%m/%Y'),
                        u.nombre_usuario
                    FROM dispersion_boletos as d INNER JOIN sucursales as s ON d.sucursal = s.id
                    INNER JOIN usuarios as u ON d.usuario = u.id
                    WHERE d.anio = '$anio'".$solo_suc." ORDER BY folio_inicial";

$consulta_dispersion = mysqli_query($conexion, $cadena_dispersion);
$cuerpo ="";
while ($row_dispersion = mysqli_fetch_array($consulta_dispersion)) {
    $porcentaje = round($row_dispersion[5],2);
    $activo = ($row_dispersion[6]=="0") ? "" : "checked";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_dispersion[0])'></center>";
    
    $renglon = "
	{
        \"id\": \"$row_dispersion[0]\",
        \"sucursal\": \"$row_dispersion[1]\",
        \"folio_inicial\": \"$row_dispersion[2]\",
        \"folio_final\": \"$row_dispersion[3]\",
        \"blocks\": \"$row_dispersion[4]\",
        \"porcentaje\": \"$porcentaje\",
        \"fecha\": \"$row_dispersion[7]\",
        \"opciones\": \"$row_dispersion[8]\",
        \"activo\": \"$chk_activo\"
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