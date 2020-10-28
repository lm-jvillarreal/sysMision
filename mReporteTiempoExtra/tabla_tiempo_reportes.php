<?php
//include '../global_seguridad/verificar_sesion.php';
include '../global_settings/consulta_sqlsrvr.php';

$filtro_registros_propios = ($registros_propios=="0") ? "" : " AND ti.usuario='$id_usuario'";
$tiempo = "";

$cadena  = "SELECT
ti.id,
ti.nombre,
d.nombre,
ti.sucursal,
usuarios.nombre_usuario,
TIME_FORMAT(hora_inicio,'%H:%s'),
TIME_FORMAT(hora_final,'%H:%s'),
TIMEDIFF(hora_final, hora_inicio),
time_format(timediff(hora_final, hora_inicio), '%T'),
ti.comentario,
date_format(ti.hora_inicio,'%d/%m/%Y'),
ti.activo,
ti.usuario
FROM
tiempo_extra AS ti
INNER JOIN departamentos AS d ON ti.departamento = d.id ,
usuarios
WHERE
ti.activo = '1' AND
ti.usuario = usuarios.id_persona AND
ti.folio = '0'
";

  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $autorizar = "<center><span class='label label-warning'>Pendiente</span></center>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $tiempo = $row_incidencias[7];
    $tiempo = substr($tiempo,0,5);
    
    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $empleado = $row_incidencias[1].' - '.$nombre_empleado; 
    
    $renglon = "
      {
      \"id\": \"$editar\",
      \"nombre\": \"$empleado\",
      \"departamento\": \"$row_incidencias[2]\",
      \"sucursal\": \"$row_incidencias[3]\",
      \"autoriza\": \"$row_incidencias[4]\",
      \"tiempo\": \"$tiempo\",
      \"comentario\": \"$row_incidencias[8]\",
      \"fecha\": \"$row_incidencias[9]\"
      },";
    $cuerpo = $cuerpo.$renglon;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
echo $tabla;
 ?>
