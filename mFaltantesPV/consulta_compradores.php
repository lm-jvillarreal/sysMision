<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//$filtro_rp = ($registros_propios == '1') ? " AND usuarios.id = '$id_usuario'" : "";

if(!isset($_POST['searchTerm'])){ 
  $cadena_proveedores = "SELECT usuarios.id, usuarios.id_persona, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno), usuarios.id_perfil
							FROM usuarios
							INNER JOIN personas 
							WHERE usuarios.id_persona = personas.id AND id_perfil = '5'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_proveedores = "SELECT usuarios.id, usuarios.id_persona, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno), usuarios.id_perfil
							FROM usuarios
							INNER JOIN personas 
							WHERE usuarios.id_persona = personas.id AND id_perfil = '5' 
							AND CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) like '%".$search."%'";
} 


$consulta_compradores = mysqli_query($conexion, $cadena_proveedores);
$data = array();
while ($row_proveedores=mysqli_fetch_array($consulta_compradores)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[2]); 
}

echo json_encode($data);
?>