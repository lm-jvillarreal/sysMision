<?php
include '../global_settings/conexion.php';
//include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_usuarios = "SELECT usuarios.id, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) 
							FROM personas
							INNER JOIN usuarios ON usuarios.id_persona =  personas.id";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_usuarios = "SELECT usuarios.id, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) 
							FROM personas
							INNER JOIN usuarios ON usuarios.id_persona =  personas.id AND CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) like '%".$search."%'";
} 


$consulta_usuarios = mysqli_query($conexion, $cadena_usuarios);

$data = array();
while ($row_usuarios=mysqli_fetch_array($consulta_usuarios)) {
	$data[] = array("id"=>$row_usuarios[0], "text"=>$row_usuarios[1]); 
}

echo json_encode($data);
?>