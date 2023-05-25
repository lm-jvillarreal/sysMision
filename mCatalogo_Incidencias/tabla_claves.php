<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
claves_apsi.id,
claves_apsi.clave,
claves_apsi.nombre,
claves_apsi.usuario,
claves_apsi.activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = claves_apsi.usuario)
FROM
claves_apsi";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_claves = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_claves[4]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editarClaves($row_claves[0])'>$row_claves[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatusClaves($row_claves[0])'></center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"clave\": \"$row_claves[1]\",
      \"nombre\": \"$row_claves[2]\",
      \"usuario\": \"$row_claves[5]\",
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