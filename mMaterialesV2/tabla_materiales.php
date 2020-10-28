<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$filtro=(!empty($registros_propios) == '1')?"AND detalle_tbodega_encargados.encargado = '$id_usuario'":"";

$cadena   = "SELECT catalogo_materiales2.id, nombre, descripcion, existencia, tipo, proveedor, pedido, (SELECT nombre FROM tipo_bodega WHERE tipo_bodega.id = catalogo_materiales2.id_tipo_bodega) 
FROM catalogo_materiales2 
INNER JOIN detalle_tbodega_encargados ON detalle_tbodega_encargados.id_bodega = catalogo_materiales2.id_tipo_bodega
WHERE detalle_tbodega_encargados.activo = '1'
AND catalogo_materiales2.activo = '1'".$filtro." GROUP BY catalogo_materiales2.id";
$consulta = mysqli_query($conexion, $cadena);

$cuerpo = "";
$numero = 1;

while ($row = mysqli_fetch_array($consulta)) {
	if($row[4] == 1){
		$cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[5]'";
		$consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    	oci_execute($consulta_proveedores);
    	$row_proveedores=oci_fetch_row($consulta_proveedores);
    	$nombre_proveedor = $row_proveedores[1];
	}else{
		$nombre_proveedor = $row[5];
	}

	if($row[6]== "1" || $row[6]== "2"){
		$clase = "success";
		$disabled = "disabled";
	}else{
		$clase = "danger";
		$disabled = "";
	}

	$boton_editar="<button onclick='editar_material($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></button>";
    $boton_eliminar="<button onclick='eliminar_material($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_pedir = "<button class='btn btn-$clase' type='button' onclick='pedir($row[0],1)' $disabled><i class='fa fa-comments fa-lg' aria-hidden='true'></i></button>";
    $existencia = "<p id='existenciabd$numero' ondblclick='activar($numero)'>$row[3]</p><input id='nueva_existencia$numero' name='nueva_existencia' class='form-control hidden' onkeyup='if(event.keyCode == 13)actualizar_existencia($row[0],this.value)' size='6'>";

	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[1]\",
		\"Proveedor\": \"$nombre_proveedor\",
		\"TBodega\": \"$row[7]\",
		\"Existencia\": \"$existencia\",
		\"Pedir\": \"$boton_pedir\",
		\"Editar\": \"$boton_editar\",
		\"Eliminar\": \"$boton_eliminar\"
		},";
	$cuerpo = $cuerpo.$renglon;
	$numero ++;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>