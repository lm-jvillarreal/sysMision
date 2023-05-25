<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
gravedad_incidencias.id,
gravedad_incidencias.gravedad,
gravedad_incidencias.activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = gravedad_incidencias.usuario)
FROM
gravedad_incidencias";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_gravedad = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_gravedad[2]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_gravedad[0])'>$row_gravedad[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatusGravedad($row_gravedad[0])'></center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"gravedad\": \"$row_gravedad[1]\",
      \"usuario\": \"$row_gravedad[3]\",
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