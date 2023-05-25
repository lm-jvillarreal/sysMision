<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_auditor = "SELECT ID, CONCAT(NOMBRE, ' ',AP_PATERNO,' ', AP_MATERNO) FROM vidvig_vigilantes WHERE ID_SUCURSAL='$id_sede'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_auditor = "SELECT ID, CONCAT(NOMBRE, ' ',AP_PATERNO,' ', AP_MATERNO) FROM vidvig_vigilantes WHERE ID_SUCURSAL='$id_sede' AND CONCAT(NOMBRE, ' ',AP_PATERNO,' ', AP_MATERNO) like '%".$search."%'";
} 


$consulta_auditor = mysqli_query($conexion, $cadena_auditor);

$data = array();
while ($row_auditor=mysqli_fetch_array($consulta_auditor)) {
	$data[] = array("id"=>$row_auditor[0], "text"=>$row_auditor[1]); 
}
echo json_encode($data);
?>