<?php
include '../global_settings/conexion.php';
//include '../global_settings/conexion_oracle.php';

$limite = "";
if (empty($_POST['usuario'])) {
	$limite = ' Limit 0';
}else{
	$limite = "";
}

if(!isset($_POST['searchTerm'])){ 
  $cadena_modulos = "SELECT id, nombre FROM modulos WHERE id NOT IN (SELECT id_modulo FROM detalle_usuario WHERE id_usuario = '".$_POST['usuario']."') AND activo = '1'".$limite;
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_modulos = "SELECT id, nombre FROM modulos WHERE id NOT IN (SELECT id_modulo FROM detalle_usuario WHERE id_usuario = '".$_POST['usuario']."') AND activo = '1' AND nombre like '%".$search."%'".$limite;
} 


$consulta_modulos = mysqli_query($conexion, $cadena_modulos);

$data = array();
while ($row_modulos=mysqli_fetch_array($consulta_modulos)) {
	$data[] = array("id"=>$row_modulos[0], "text"=>$row_modulos[1]); 
}
//echo $_POST['usuario'];
//echo "<br>";
//echo $cadena_modulos;
echo json_encode($data);
?>