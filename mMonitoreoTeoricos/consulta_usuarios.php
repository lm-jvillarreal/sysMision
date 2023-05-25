<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){
  $cadena_catalogo = "SELECT u.id, 
                      (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE id = u.id_persona)
                      FROM detalle_usuario as d INNER JOIN usuarios as u ON d.id_usuario = u.id
                      WHERE u.activo = '1' 
                      and d.id_modulo= '135'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_catalogo = "SELECT u.id, 
                    (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE id = u.id_persona)
                    FROM detalle_usuario as d INNER JOIN usuarios as u ON d.id_usuario = u.id
                    WHERE u.activo = '1' 
                    and d.id_modulo= '135'
                    AND (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE id = u.id_persona) LIKE '%".$search."%'";
} 
$consulta_catalogo = mysqli_query($conexion, $cadena_catalogo);
$data = array();
while ($row_catalogo=mysqli_fetch_array($consulta_catalogo)) {
	$data[] = array("id"=>$row_catalogo[0], "text"=>$row_catalogo[1]); 
}

echo json_encode($data);
?>