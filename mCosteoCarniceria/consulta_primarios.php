<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_primarios = "SELECT CODIGO_CORTE, DESCRIPCION_CORTE FROM carniceria_catalogo WHERE ACTIVO='1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_primarios = "SELECT CODIGO_CORTE, DESCRIPCION_CORTE FROM carniceria_catalogo WHERE ACTIVO='1' AND DESCRIPCION_CORTE LIKE '%".$search."%'";
}
$consulta_primarios = mysqli_query($conexion, $cadena_primarios);
$data = array();
while ($row_primarios=mysqli_fetch_array($consulta_primarios)) {
	$data[] = array("id"=>$row_primarios[0], "text"=>$row_primarios[0].' - '.$row_primarios[1]); 
}
echo json_encode($data);
?>