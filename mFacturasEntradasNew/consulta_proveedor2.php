<?php
include '../global_seguridad/verificar_sesion.php';

//$filtro_rp = ($solo_sucursal == '1') ? " AND id = '$id_sede'" : "";

if(!isset($_POST['searchTerm'])){ 
  $cadena = "SELECT proveedor FROM notas_entrada GROUP BY proveedor";//.$filtro_rp;
}else{ 
  $search = $_POST['searchTerm'];
  $cadena = "SELECT proveedor FROM notas_entrada WHERE proveedor like '%".$search."%' GROUP BY proveedor";
} 

$consulta = mysqli_query($conexion, $cadena);
$data = array();
while ($row=mysqli_fetch_array($consulta)) {
	$data[] = array("id"=>$row[0], "text"=>$row[0]);
}

echo json_encode($data);
?>