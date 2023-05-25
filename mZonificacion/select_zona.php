<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_zonas = "SELECT
                    inv_zonas
                  FROM
                    sucursales
                    where id='$id_sede'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_zonas = "";
} 
$consulta_zonas = mysqli_query($conexion, $cadena_zonas);
$row_zonas=mysqli_fetch_array($consulta_zonas);
$data = array();
for($i=1;$i<=$row_zonas[0];$i=$i+1){
	$data[] = array("id"=>$i, "text"=>$i); 
}

echo json_encode($data);
?>