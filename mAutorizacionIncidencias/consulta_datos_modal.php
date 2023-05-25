<?php
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
  
$id_registro = $_POST['id_registro'];
$incidencia  = $_POST['incidencia'];
$accion      = $_POST['accion'];
$comentario  = $_POST['comentario'];
$decision    = $_POST['decision'];
$incidencia  = $row_resultado[2];
$accion      = $row_resultado[3];
$comentario  = $row_resultado[4];
$decision    = $row_resultado[5];


  $cadena = mysqli_query($conexion,"SELECT
  i.id,
  i.nombre,
  i.comentario,
  ci.id,
  ci.incidencia,
  sanciones_incidencias.nombre,
  i.decision,
  i.comentario_fin,
  (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = i.usuario)
  FROM
  incidencias i
  INNER JOIN catalogo_incidencias ci, sanciones_incidencias
  WHERE
  i.incidencia = ci.id and i.accion=sanciones_incidencias.nombre
	AND i.id = '$id_registro'");

  $row_resultado  = mysqli_fetch_array($cadena);

  $cadena_persona = "SELECT codigo, (nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_resultado[1]'";
  $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  $row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

  
  $array2 = array(
    $row['nombre'],
    $id_registro,
    $row_resultado[4],
    $row_resultado[5],
    $row_resultado[2],

  	);

  $array = json_encode($array2);
  echo "$array";
?>