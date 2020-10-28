<?php
include '../global_seguridad/verificar_sesion.php';

$ide_usuario = ($_POST['ide_usuario']=="") ? $id_usuario : $_POST['ide_usuario'];
$cadena_consulta = "SELECT detalle_usuario.id, detalle_usuario.id_modulo, modulos.nombre, detalle_usuario.solo_sucursal, detalle_usuario.registros_propios, detalle_usuario.solo_lectura 
					FROM detalle_usuario inner join modulos ON detalle_usuario.id_modulo = modulos.id
					WHERE id_usuario = '$ide_usuario'";

$consulta_modulos = mysqli_query($conexion, $cadena_consulta);

$cuerpo = "";
while ($row_modulos = mysqli_fetch_array($consulta_modulos)) {
	$solo_sucursal = ($row_modulos[3]=="0") ? "" : "checked";
	$registros_propios = ($row_modulos[4]=="0") ? "" : "checked";
	$solo_lectura = ($row_modulos[5]=="0") ? "" : "checked";

	$chk_solo_sucursal = "<center><input type='checkbox' name='solo_sucursal' id='solo_sucursal' $solo_sucursal onchange='solo_sucursal($row_modulos[0])'></center>";
	$chk_registros_propios = "<center><input type='checkbox' name='registros_propios' id='registros_propios' $registros_propios onchange='registros_propios($row_modulos[0])'></center>";
	$chk_solo_lectura = "<center><input type='checkbox' name='solo_lectura' id='solo_lectura' $solo_lectura onchange='solo_lectura($row_modulos[0])'></center>";
	$acceso = "<center><a href='#' class='btn btn-danger' onclick='revocar_permiso($row_modulos[0])'>Revocar</center>";

	$renglon = "
	{
		\"id\": \"$row_modulos[0]\",
		\"modulo\": \"$row_modulos[2]\",
		\"solo_sucursal\": \"$chk_solo_sucursal\",
	    \"registros_propios\": \"$chk_registros_propios\",
	    \"solo_lectura\": \"$chk_solo_lectura\",
	    \"acceso\": \"$acceso\"
	  },";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>