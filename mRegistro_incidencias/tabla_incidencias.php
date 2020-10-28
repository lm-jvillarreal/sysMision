<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_incidencias = "SELECT  inc.id, 
                        suc.nombre, 
                        inc.momento, 
                        inc.descripcion,
                        cat.categoria,
                        tipo.incidencia,
                        deptos.nombre,
                        DATE_FORMAT(inc.fecha_incidencia,'%d/%m/%Y'),
                        inc.detalle,
                        inc.url_video
                        FROM registroIncidencias_vidvig  as inc
                        INNER JOIN sucursales as suc ON inc.id_sucursal = suc.id
                        INNER JOIN categorias_vidvig as cat ON inc.id_categoria = cat.id
                        INNER JOIN incidencias_vidvig as tipo ON inc.tipo_incidencia = tipo.id
                        INNER JOIN departamentos as deptos ON inc.id_area = deptos.id
                        ORDER BY inc.id DESC";

$consulta_incidencias = mysqli_query($conexion, $cadena_incidencias);
$cuerpo ="";
while ($row_incidencias = mysqli_fetch_array($consulta_incidencias)) {
    $escape_comentario = mysqli_real_escape_string($conexion, $row_incidencias[8]);
    $escape_descripcion = mysqli_real_escape_string($conexion, $row_incidencias[3]);
    if($row_incidencias[9]==NULL){
        $link_incidencias = $row_incidencias[0];
    }else{
        $link_incidencias = "<center><a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-video' target='blank'>$row_incidencias[0]</a></center>";
    }
	$renglon = "
	{
		\"id\": \"$link_incidencias\",
		\"sucursal\": \"$row_incidencias[1]\",
		\"momento\": \"$row_incidencias[2]\",
        \"descripcion\": \"$escape_descripcion\",
        \"categoria\": \"$row_incidencias[4]\",
        \"incidencia\": \"$row_incidencias[5]\",
        \"area\": \"$row_incidencias[6]\",
        \"fecha_incidencia\": \"$row_incidencias[7]\",
        \"detalle\": \"$escape_comentario\"
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