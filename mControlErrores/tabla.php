<?php
include '../global_settings/conexion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

if(isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])){
  $fecha_inicio = $_POST['fecha_inicio'];
  $fecha_fin    = $_POST['fecha_fin'];
  
  $cadena_errores = "SELECT
          id,
          tipo_mov,
          folio_mov,
        CASE
            id_sucursal 
            WHEN '1' THEN
            'Diaz Ordaz' 
            WHEN '2' THEN
            'Arboledas' 
            WHEN '3' THEN
            'Villegas' 
            WHEN '4' THEN
            'Allende' 
            ELSE 'Otra'
          END AS sucursal,
          ctb_usuario,
          nombre_usuario,
          (SELECT comentarios_errores.nombre FROM comentarios_errores WHERE comentarios_errores.id = me_control_errores.comentarios) AS Comm
        FROM
          me_control_errores
          WHERE folio_mov IS NOT NULL AND folio_mov != ''
          AND fecha BETWEEN CAST('$fecha_inicio' AS DATE)
          AND CAST('$fecha_fin' AS DATE)";
}
else{
  $cadena_errores = "SELECT
          id,
          tipo_mov,
          folio_mov,
        CASE
            id_sucursal 
            WHEN '1' THEN
            'Diaz Ordaz' 
            WHEN '2' THEN
            'Arboledas' 
            WHEN '3' THEN
            'Villegas' 
            WHEN '4' THEN
            'Allende' 
            ELSE 'Otra'
          END AS sucursal,
          ctb_usuario,
          nombre_usuario,
          (SELECT comentarios_errores.nombre FROM comentarios_errores WHERE comentarios_errores.id = me_control_errores.comentarios) AS Comm
        FROM
          me_control_errores
          WHERE folio_mov IS NOT NULL AND folio_mov != ''";
}

$consulta_errores = mysqli_query($conexion, $cadena_errores);

$cuerpo ="";
$cadena = "";
$comentarios = "";
$editar = "";
$numero = 0;
while ($row_errores = mysqli_fetch_array($consulta_errores)) {
  $link_editar = "<center><a href='#' onclick='datos_editar($row_errores[0])'>$row_errores[0]</a></center>";
  $renglon = "
    {
    \"id\": \"$link_editar\",
    \"tipo_mov\": \"$row_errores[1]\",
    \"folio_mov\": \"$row_errores[2]\",
    \"sucursal\": \"$row_errores[3]\",
    \"ctb_usuario\": \"$row_errores[4]\",
    \"nombre_usuario\": \"$row_errores[5]\",
    \"comentarios\": \"$row_errores[6]\"
    },";
  $cuerpo = $cuerpo.$renglon;
  $numero ++;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>