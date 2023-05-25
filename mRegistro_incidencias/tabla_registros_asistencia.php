<?php
  // esto permite tener acceso desde otro servidor
    header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  // include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion2.php';
  include '../global_settings/consulta_sqlsrvr.php';

$filtro_registros_propios = ($registros_propios=="0") ? "" : " AND i.usuario='$id_usuario'";
$departamento = "";
$nombre_empleado="";
$sucursal="";
$cadena  = "SELECT
incidencias.id,
incidencias.nombre,
incidencias.departamento,
catalogo_incidencias.nombre as incidencia,
incidencias.sucursal,
incidencias.activo,
incidencias.comentario,
catalogo_formatos.nombre as categoria,
DATE_FORMAT(incidencias.fecha, '%d/%m/%Y')
FROM
incidencias ,
catalogo_incidencias ,
catalogo_formatos, 
sanciones_incidencias
WHERE
incidencias.categoria = catalogo_formatos.id AND
incidencias.incidencia = catalogo_incidencias.id_incidencia and incidencias.activo='1' and incidencias.folio='3' group by id";//.$filtro_registros_propios;
  //modificar la consulta de la tabla para ligar registros con sql
  //modificar bd para agregar datos textules y no ligar por id con tablas de mySql        
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $departamento =ucfirst(strtolower($row_incidencias[2]));
    $sucursal=ucfirst(strtolower($row_incidencias[4]));
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_incidencias[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_incidencias[1].' - '.$nombre_empleado; 
    $renglon = "
      {
      \"id\": \"$editar\",
      \"nombre\": \"$empleado\",
      \"departamento\": \"$departamento\",
      \"sucursal\": \"$sucursal\",
      \"incidencia\": \"$row_incidencias[3]\",
      \"categoria\": \"$row_incidencias[7]\",  
      \"activo\": \"$row_incidencias[5]\",
      \"fecha\": \"$row_incidencias[8]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $departamento="";
    $nombre_empleado="";

  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>