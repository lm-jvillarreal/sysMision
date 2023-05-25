<?php
  // esto permite tener acceso desde otro servidor
   //header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
  // include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';
$filtro_registros_propios = ($registros_propios=="0") ? "" : " AND i.usuario='$id_usuario'";

$nombre_empleado="";
$departamento="";
$sucursal="";

$cadena  = "SELECT
i.id,
i.nombre,
i.departamento,
i.sucursal,
ci.incidencia,
i.activo,
i.folio,
i.comentario
FROM incidencias i INNER JOIN catalogo_incidencias ci
WHERE i.incidencia= ci.id AND i.folio ='0'";

           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $autorizar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-success' target='blank'>Autorizar</a>";
    $rechazar = "<a href='#' data-id = '$row_incidencias[0]' data-toggle = 'modal' data-target = '#modal-rechazar' class='btn btn-danger' target='blank'>Rechazar</a>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $departamento=ucwords(strtolower($row_incidencias[2]));
    $sucursal=ucwords(strtolower($row_incidencias[3]));

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
      \"incidencia\": \"$row_incidencias[4]\",
      \"comentario\": \"$row_incidencias[7]\",
      \"activo\": \"$autorizar\",
      \"rechazar\": \"$rechazar\"
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