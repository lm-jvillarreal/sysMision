<?php
// esto permite tener acceso desde otro servidor
   // header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  // include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';

$id_registroo      = $_POST['id_registroo'];
$registro          = $_POST['registro'];
$sugerencia        = $_POST['sugerencia'];
$comentario_inicio =$_POST['comentario_inicio'];
$comentario_final  =$_POST['comentario_final'];
$folio             = $_POST['folio'];
$registro          = $row_resultado[2];
$sugerencia        = $row_resultado[3];
$comentario        = $row_resultado[4];
$comentario_final  =$row_resultado[5];
$folio             =$row_resultado[6];


  $cadena = mysqli_query($conexion,"SELECT
	i.id,
	i.nombre,
	i.incidencia AS id_incidencia,
	( SELECT incidencia FROM catalogo_incidencias ci WHERE i.incidencia = ci.id ) AS incidencia,
	i.accion AS id_sancion,
	( SELECT nombre FROM sanciones_incidencias si WHERE i.accion = si.id ) AS sancion,
	i.comentario,
	(
	SELECT
		CONCAT( nombre, ' ', ap_paterno, ' ', ap_materno ) 
	FROM
		usuarios
		INNER JOIN personas ON personas.id = usuarios.id_persona 
	WHERE
		usuarios.id = i.usuario 
	) 
FROM
	incidencias i 
WHERE
	i.activo = '1'
	AND i.id = '$id_registroo'");

  $row_resultado  = mysqli_fetch_array($cadena);

  $cadena_persona = "SELECT codigo, (nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_resultado[1]' ";
  $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  $row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);


  $array2 = array(
    $row['nombre'],
    $id_registroo,
    // $row_resultado[1],//nombre_sql
    $row_resultado[2],//id_incidencia
    $row_resultado[3],//incidencia
    $row_resultado[4],//id_sancion
    $row_resultado[5],//sancion
    $row_resultado[6]//comentario
  	);
  $array = json_encode($array2);
  echo $array;
?>