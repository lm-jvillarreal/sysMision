<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
sanciones_incidencias.id,
sanciones_incidencias.nombre,
sanciones_incidencias.activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = sanciones_incidencias.usuario)
FROM
sanciones_incidencias";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_acciones = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_acciones[2]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_acciones[0])'>$row_acciones[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_acciones[0])'></center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"accion_sugerida\": \"$row_acciones[1]\",
      \"usuario\": \"$row_acciones[3]\",
      \"activo\": \"$chk_activo\"
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