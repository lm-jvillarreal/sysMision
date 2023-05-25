<?php
// include '../global_seguridad/verificar_sesion.php';
// esto permite tener acceso desde otro servidor
    header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
include '../global_settings/conexion2.php';
Include '../global_settings/consulta_sqlsrvr.php';

$id = $_POST['id'];

$cadena_consulta = " SELECT
i.id,
i.nombre,
cf.id,
cf.nombre as categoria,
ci.id_incidencia,
ci.nombre as incidencia,
i.comentario,
si.id,
si.nombre,
i.decision, 
i.fecha_uno,
i.fecha_dos
FROM
incidencias i
INNER JOIN catalogo_formatos cf , catalogo_incidencias ci, sanciones_incidencias si
WHERE
i.categoria = cf.id AND i.incidencia=ci.id_incidencia AND i.accion= si.id
and i.id='$id'";

$consulta_editar = mysqli_query($conexion, $cadena_consulta);
$row_editar = mysqli_fetch_array($consulta_editar);

$cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_editar[1]'";

$consulta_persona = sqlsrv_query($conn, $cadena_persona);
$row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

	$nombre = $row['nombre'];
	$array = array(
	$row_editar[0],//id
	$row_editar[1],//nombre mysql
	$nombre,//nombre sql
	$row_editar[2],//incidencia
	$row_editar[3],
	$row_editar[4],//idcategoria
	$row_editar[5],//categoria
	$row_editar[6],//idincidencia
	$row_editar[7],//incidencia
	$row_editar[8],//comentario
	$row_editar[9],//idaccion
	$row_editar[10],//accion
	$row_editar[11]);//fecha_uno

$array_datos = json_encode($array);
echo $array_datos;
?>