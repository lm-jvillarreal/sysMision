<?php
include '../global_seguridad/verificar_sesion.php';

$filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
$filtro = "";
$cadena   = "SELECT tipo_bodega.id, nombre, tipo FROM tipo_bodega 
				INNER JOIN detalle_tbodega_usuarios ON detalle_tbodega_usuarios.id_bodega = tipo_bodega.id WHERE tipo_bodega.activo = '1' ".$filtro;
$consulta = mysqli_query($conexion, $cadena);

$cuerpo    = "";
$numero    = 1;
$encargado = "";
$usuarios  = "";

while ($row = mysqli_fetch_array($consulta)) {
	//Encargados
	$cadena2 = mysqli_query($conexion, "SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = detalle_tbodega_encargados.encargado ) FROM detalle_tbodega_encargados WHERE id_bodega = '$row[0]'");
	$cantidad2 = mysqli_num_rows($cadena2);
	while($row2 = mysqli_fetch_array($cadena2)){
		$add = ($cantidad2 >= 2)?"<br>":"";
		$encargado .= $row2[0].$add;
	}
	$cadena3 = ($row[2] == 1)?"SELECT (SELECT nombre FROM perfil WHERE perfil.id = detalle_tbodega_usuarios.usuario) FROM detalle_tbodega_usuarios WHERE id_bodega = '$row[0]'":"SELECT (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = detalle_tbodega_usuarios.usuario ) FROM detalle_tbodega_usuarios WHERE id_bodega = '$row[0]'";
	// echo $cadena3;

	$cadena4 = mysqli_query($conexion,$cadena3);
	while($row3 = mysqli_fetch_array($cadena4)){
		$usuarios .= $row3[0].'<br>';
	}


	$boton_editar="<button onclick='editar_tb($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></button>";
    $boton_eliminar="<button onclick='eliminar_tb($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";

	$renglon = "
		{
		\"#\": \"$numero\",
		\"Nombre\": \"$row[1]\",
		\"Encargado\": \"$encargado\",
		\"Usuarios\": \"$usuarios\",
		\"Editar\": \"$boton_editar\",
		\"Eliminar\": \"$boton_eliminar\"
		},";
	$cuerpo = $cuerpo.$renglon;
	$numero ++;
	$encargado = "";
	$usuarios  = "";
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>