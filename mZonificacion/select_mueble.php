<?php
include '../global_seguridad/verificar_sesion.php';
$area=$_POST['area'];
$zona=$_POST['zona'];
if(!isset($_POST['searchTerm'])){ 
  $cadena_muebles = "SELECT
                      ID, CONCAT(MUEBLE,' - ',TIPO_MUEBLE)
                    FROM
                      inv_muebles 
                    WHERE
                      ID_SUCURSAL = '$id_sede' 
                      AND ID_AREA = '$area' 
                      AND ZONA = '$zona'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_muebles = "";
} 
$consulta_muebles = mysqli_query($conexion, $cadena_muebles);

$data = array();
while ($row_muebles=mysqli_fetch_array($consulta_muebles)) {
	$data[] = array("id"=>$row_muebles[0], "text"=>$row_muebles[1]);
}
echo json_encode($data);
?>