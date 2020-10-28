<?php
include '../global_settings/conexion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_depto = "SELECT DISTINCT(ID_DEPTO),
                    (SELECT nombre FROM departamentos WHERE id=revision_cierre.ID_DEPTO)
                    FROM revision_cierre";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_depto = "SELECT DISTINCT(ID_DEPTO),
                  (SELECT nombre FROM departamentos WHERE id=revision_cierre.ID_DEPTO AND nombre like '%".$search."%')
                  FROM revision_cierre";
} 

$consulta_depto = mysqli_query($conexion, $cadena_depto);

$data = array();
while ($row_depto=mysqli_fetch_array($consulta_depto)) {
	$data[] = array("id"=>$row_depto[0], "text"=>$row_depto[1]); 
}
echo json_encode($data);
?>