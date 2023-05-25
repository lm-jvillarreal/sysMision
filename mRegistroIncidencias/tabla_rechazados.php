<?php
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';

$nombre_empleado="";
$sucursal="";
$departamento="";

$cadena  = "SELECT
i.id,
i.nombre,
i.departamento,
i.sucursal,
ci.incidencia  as incidencia,
i.activo,
i.folio,
i.comentario
FROM incidencias i INNER JOIN catalogo_incidencias ci
WHERE i.incidencia= ci.id AND i.activo='1' and i.folio ='2'";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_incidencias[5]=="0") ? "" : "checked";
    $autorizar = "<center><span class='label label-danger'>Rechazado</span></center>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $sucursal=ucwords(strtolower($row_incidencias[3]));
    $departamento=ucwords(strtolower($row_incidencias[2]));
    
    
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
      \"activo\": \"$autorizar\"
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
 