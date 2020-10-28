<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$filtro_sucursal =($solo_sucursal=='1') ? " AND personas.id_sede='$id_sede'":"";

if(!isset($_POST['searchTerm'])){ 
  $cadena_proveedores = "SELECT usuarios.id, usuarios.id_persona, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno), usuarios.id_perfil
							FROM usuarios
							INNER JOIN personas 
							WHERE usuarios.id_persona = personas.id AND (id_perfil = '14' OR id_perfil = '12')".$filtro_sucursal;
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_proveedores = "SELECT usuarios.id, usuarios.id_persona, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno), usuarios.id_perfil
							FROM usuarios
							INNER JOIN personas 
							WHERE usuarios.id_persona = personas.id AND (id_perfil = '14' OR id_perfil = '12')".$filtro_sucursal."
							AND CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) like '%".$search."%'";
} 


$consulta_compradores = mysqli_query($conexion, $cadena_proveedores);
$data = array();
while ($row_proveedores=mysqli_fetch_array($consulta_compradores)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[2]); 
}
echo json_encode($data);
?>