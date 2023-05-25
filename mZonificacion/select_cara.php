<?php
include '../global_seguridad/verificar_sesion.php';
$area=$_POST['area'];
$zona=$_POST['zona'];
$mueble=$_POST['mueble'];
if(!isset($_POST['searchTerm'])){ 
  $cadena_cara = "SELECT
                    ID,
                    CARA_MUEBLE 
                  FROM
                    inv_caramuebles 
                  WHERE
                    ID_MUEBLE = '$mueble' 
                    AND ACTIVO = '1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_cara = "";
} 
$consulta_cara = mysqli_query($conexion, $cadena_cara);

$data = array();
while ($row_cara=mysqli_fetch_array($consulta_cara)) {
	$data[] = array("id"=>$row_cara[0], "text"=>$row_cara[1]);
}
echo json_encode($data);
?>