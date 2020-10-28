<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_usuarios = "SELECT usuarios.id, CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas INNER JOIN usuarios ON personas.id=usuarios.id_persona WHERE usuarios.id_perfil ='2' AND usuarios.activo='1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_usuarios = "SELECT usuarios.id, CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas INNER JOIN usuarios ON personas.id=usuarios.id_persona WHERE usuarios.id_perfil ='2' AND usuarios.activo='1' AND CONCAT(nombre,' ',ap_paterno,' ',ap_materno) like '%".$search."%'";
} 
$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);
$data = array();
while ($row_usuarios=mysqli_fetch_array($consulta_usuarios)) {
	$data[] = array("id"=>$row_usuarios[0], "text"=>$row_usuarios[1]);
}
echo json_encode($data);
?>