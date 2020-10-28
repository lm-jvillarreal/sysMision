<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT id, nombre, activo FROM catalogo_formatos";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_incidencias[2]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_incidencias[0])'></center>";
    $renglon = "
      {
      \"id_incidencia\": \"$editar\",
      \"nombre\": \"$row_incidencias[1]\",
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