
<?php
include '../global_settings/conexion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$id_depto=$_POST['id_depto'];
$sucursal = $_POST['sucursal'];

$cadena_indicadores = "SELECT ID, AREA FROM revision_cierre WHERE ID_DEPTO = '$id_depto' AND ID_SUCURSAL  = '$sucursal'";
$consulta_indicadores = mysqli_query($conexion, $cadena_indicadores);

$data = array();

while ($row_tarea = mysqli_fetch_array($consulta_indicadores)) {
  array_push($data,array(
    'ID'=>$row_tarea[0],
    'nombre'=>$row_tarea[1]
  ));
}
echo utf8_encode(json_encode($data));
?>