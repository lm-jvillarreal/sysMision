<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_codigos = "SELECT c.id, c.codigo, c.articulo, c.costo, s.nombre, c.comentario, c.baja, c.estatus 
                        FROM costos_cero as c
                        INNER JOIN sucursales as s ON c.sucursal = s.id WHERE (c.estatus = '1' or c.estatus = '2')";

$consulta_codigos = mysqli_query($conexion, $cadena_codigos);

$cuerpo ="";

while ($row_codigos = mysqli_fetch_array($consulta_codigos)) {

    $escape_comentario = mysqli_real_escape_string($conexion, $row_codigos[5]);
    $editar = "<center><a href='#' data-id = '$row_codigos[0]' data-toggle = 'modal' data-target = '#modal-costos' target='blank'>$row_codigos[0]</a></center>";
    $baja = "<a href='#' class='btn btn-warning' onclick='baja($row_codigos[0])'$solo_lectura>Baja</a>";
    if($row_codigos[7]=='1'){
        $estatus = "<small class='label label-danger'><i class='fa fa-clock-o'></i> Pendiente</small>";
    }elseif($row_codigos[7]=='2'){
        $estatus = "<small class='label label-warning'><i class='fa fa-clock-o'></i> Resuelto</small>";
    }elseif($row_codigos[7]=='3'){
        $estatus = "<small class='label label-success'><i class='fa fa-clock-o'></i> Corregido</small>";
    }
    $liberar = "<center><a href='#' class='btn btn-danger' onclick='liberar($row_codigos[0])'$solo_lectura><i class='fa fa-check' aria-hidden=true'></i></a></center>";
    $cadena_pv = "SELECT artn_precioventa FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$row_codigos[1]'";
    $link_detalle = "<center><a href='#' data-id = '$row_codigos[1]' data-toggle = 'modal' data-target = '#modal-ventas' class='btn btn-danger' target='blank'>$row_codigos[1]</a></center>";
    $consulta_pv = oci_parse($conexion_central,$cadena_pv);
	oci_execute($consulta_pv);
    $row_pv = oci_fetch_row($consulta_pv);
    $precio_venta = number_format($row_pv[0],2,'.',' ');
    $escape_desc = mysqli_real_escape_string($conexion,$row_codigos[2]);
	$renglon = "
		{
            \"id\": \"$editar\",
            \"codigo\": \"$link_detalle\",
            \"codigo2\": \"$row_codigos[1]\",
            \"descripcion\": \"$escape_desc\",
            \"costo\": \"$row_codigos[3]\",
            \"sucursal\": \"$row_codigos[4]\",
            \"pv\": \"$precio_venta\",
            \"comentario\": \"$escape_comentario\",
            \"baja\": \"$baja\",
            \"estatus\": \"$estatus\",
            \"liberar\": \"$liberar\"
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
