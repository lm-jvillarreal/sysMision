<?php
// esto permite tener acceso desde otro servidor
    //header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  // include '../global_seguridad/verificar_sesion.php';
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
	i.incidencia AS id_incidencia,
	ci.incidencia,
	i.accion,
	i.comentario,
  i.fecha,
  i.empleado
FROM
	incidencias i
	INNER JOIN catalogo_incidencias ci ON i.incidencia = ci.id 
WHERE
	i.folio = '0'
	AND i.id = '$id_registro'");

  $row_resultado  = mysqli_fetch_array($cadena);
  $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_resultado[1]'";
  $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
  $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
  $nombre_empleado=ucwords(strtolower($nombre_empleado));
  if($row_resultado[7]==""){
    $empleado = $row_resultado[1].'  '.$nombre_empleado;
  }else{
    $empleado = $row_resultado[1].' '.$row_resultado[7]; 
  }
  

  // $cadena_persona = "SELECT codigo, (nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_resultado[1]'";
  // $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  // $row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
  // $empleado=$row['nombre'];
  // $nombre=$empleado.' '.$row_resultado[7];

  $array2 = array(
    $empleado,
    $id_registro,
    $row_resultado[4],//accion sugerida
    $row_resultado[5],//comentario
    $row_resultado[3],//incidencia
    $row_resultado[6]
  	);

  $array = json_encode($array2);
  echo "$array";
?>