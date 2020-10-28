<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_consulta = "SELECT id, 
						   nombre, 
						   ap_paterno, 
						   ap_materno, 
						   fecha_nac, 
						   sexo, 
						   rfc, 
						   curp, 
						   e_mail, 
						   telefono, 
						   colonia, 
						   calle, 
						   numero, 
						   ecivil, 
						   municipio, 
						   estado,
						   telprocede, 
						   departamento, 
						   ext, 
						   titulo, 
						   num_empleado FROM personas WHERE id = '$id_persona'";
  $consulta_persona = mysqli_query($conexion, $cadena_consulta);

  $row_persona = mysqli_fetch_array($consulta_persona);

  $cadena_municipio = "SELECT id, opcion FROM sepomex_municipios WHERE id ='$row_persona[14]'";
  $consulta_municipio = mysqli_query($conexion, $cadena_municipio);
  $row_municipio = mysqli_fetch_array($consulta_municipio);

$array = array(
	$row_persona[0],
	$row_persona[1],
	$row_persona[2],
	$row_persona[3],
	$row_persona[4],
	$row_persona[5],
	$row_persona[6],
	$row_persona[7],
	$row_persona[8],
	$row_persona[9],
	$row_persona[10],
	$row_persona[11],
	$row_persona[12],
	$row_persona[13],
	$row_persona[14],
	$row_persona[15],
	$row_persona[16],
	$row_municipio[1],
	$row_persona[17],
	$row_persona[18],
	$row_persona[19],
	$row_persona[20]
);
$array_datos = json_encode($array);
echo $array_datos;
?>