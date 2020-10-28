<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$fecha1 = $_POST['fecha1'];
$fecha2 = $_POST['fecha2'];

$filtro_sucursal =($solo_sucursal=='1') ? " AND sucursal='$id_sede'":"";

$cadena_cambios = "SELECT 
                    b.id, 
                    b.tipo, 
                    b.descripcion, 
                    DATE_FORMAT(b.fecha_captura, '%d/%m/%Y %H:%i:%s'), 
                    b.sucursal, 
                    b.comentario_libera, 
                    b.liberado, 
                    b.nombre_encargado,
                    (SELECT nombre_usuario FROM usuarios WHERE id = b.usuario_captura),
                    (SELECT nombre_usuario FROM usuarios WHERE id = b.usuario_libera),
                    b.validado,
                    TIMEDIFF(b.fecha_libera,b.fecha_captura),
                    b.folio,
                    DATE_FORMAT(b.fecha_libera, '%d/%m/%Y %H:%i:%s')
                    FROM bitacora_cambios as b
                    WHERE  b.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)".$filtro_sucursal;
$consulta_cambios = mysqli_query($conexion, $cadena_cambios);

$cuerpo ="";

while ($row_cambios = mysqli_fetch_array($consulta_cambios)) {
    $escape_comentario = mysqli_real_escape_string($conexion, $row_cambios[5]);
    $folio = $row_cambios[1].'-'.$row_cambios[12];
    if($row_cambios[6]=='0'){
        $est = "<center><span class='label label-danger'>Ignorado</span></center>";
    }elseif($row_cambios[6]=='1' && $row_cambios[10]=='1'){
        $est = "<center><span class='label label-success'>Validado</span></center>";
    }elseif($row_cambios[6]=='1' && $row_cambios[10]=='0'){
        $est = "<center><span class='label label-warning'>Liberado</span></center>";
    }
	$renglon = "
		{
		\"id\": \"$row_cambios[0]\",
		\"tipo\": \"$folio\",
        \"descripcion\": \"$row_cambios[2]\",
        \"sucursal\": \"$row_cambios[4]\",
        \"fecha_captura\": \"$row_cambios[3]\",
        \"fecha_libera\": \"$row_cambios[13]\",
        \"duracion\": \"$row_cambios[11]\",
        \"comentario\": \"$escape_comentario\",
        \"solicita\": \"$row_cambios[8]\",
        \"libera\": \"$row_cambios[9]\",
        \"estatus\": \"$est\"
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