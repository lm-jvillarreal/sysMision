<?php
include '../global_seguridad/verificar_sesion.php';

$id_bodega = $_POST['id_bodega'];
// $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
$cadena   = "SELECT id, (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = detalle_tbodega_encargados.encargado) FROM detalle_tbodega_encargados WHERE activo = '1' AND id_bodega = '$id_bodega'";
$consulta = mysqli_query($conexion, $cadena);

$cuerpo = "";
$numero = 1;

while ($row = mysqli_fetch_array($consulta)) {

    $boton_eliminar="<button onclick='eliminar_encargado_tb($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";

	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[1]\",
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