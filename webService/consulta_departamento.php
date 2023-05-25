<?php
include '../global_settings/conexion.php';
$usuario = $_POST["usuario"];
$sucursal = $_POST["sucursal"];
$cadena_depto = "SELECT DISTINCT(ID_DEPTO),
                (SELECT nombre FROM departamentos WHERE id=revision_cierre.ID_DEPTO)
                FROM revision_cierre WHERE ID_SUCURSAL = '$sucursal'";

$consulta_depto = mysqli_query($conexion, $cadena_depto);

$data = array();
while ($row_depto=mysqli_fetch_array($consulta_depto)) {
  //$data[] = array("id"=>$row_depto[0], "nombre"=>$row_depto[1]); 
  array_push($data,array(
    'ID'=>$row_depto[0],
    'nombre'=>$row_depto[1]
  ));
}
echo utf8_encode(json_encode($data));
?>