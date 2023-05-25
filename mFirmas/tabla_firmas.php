<?php
include '../global_settings/consulta_sqlsrvr.php';
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
fa.id,
fa.nombre,
fa.departamento,
fa.sucursal,
fa.puesto,
p.nombre AS permiso,
fa.id_permiso,
fa.activo 
FROM
firmas_autorizadas AS fa
INNER JOIN permisos AS p ON fa.id_permiso = p.id_permiso 
WHERE
fa.activo = '1'";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";
  $numero         = 1;

  while ($row_firmas = mysqli_fetch_array($consulta)) 
  {
    $cadena1 = mysqli_query($conexion,"SELECT p.nombre FROM firmas_autorizadas fa INNER JOIN permisos p ON p.id_permiso = fa.id_permiso WHERE fa.puesto ='$row_firmas[2]' AND fa.activo = '1'");

    $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_firmas[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
    $nombre_empleado=ucwords(strtolower($nombre_empleado));
    $empleado = $row_firmas[1].' - '.$nombre_empleado; 

    $cantidad = mysqli_num_rows($cadena1);
    $numero2 = 1;
    $activo = ($row_firmas[7]=="0") ? "" : "checked";
 
    $boton_editar = "<a class='btn btn-warning' href='#' onclick='eliminar($row_firmas[0])'>Eliminar</a>";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $firma= "<a href='#' data-id = '$row_firmas[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'> <i class=''></i>Firmas </a>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_firmas[0])'></center>";
    $renglon = "
      {
      \"id\": \"$numero\",
      \"nombre\": \"$empleado\",
      \"puesto\": \"$row_firmas[4]\",
      \"permisos\": \"$row_firmas[5]\",
      \"firma\": \"$firma\",
      \"activo\": \"$chk_activo\",
      \"eliminar\": \"$boton_editar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++; 
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>