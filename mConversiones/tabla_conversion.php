<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
id, conversion, medida, masa, tortillas, resultado, id_usuario, fechahora, activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = conversiones_tor.id_usuario)
FROM
conversiones_tor";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_acciones = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_acciones[2]=="8") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_acciones[0])'>$row_acciones[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_acciones[0])'></center>";
    $renglon = "
      {
      \"id\": \"$row_acciones[0]\",
      \"conversion\": \"$row_acciones[1]\",
      \"medida\": \"$row_acciones[2]\",
      \"masa\": \"$row_acciones[3]\",
      \"tortillas\": \"$row_acciones[4]\",
      \"resultado\": \"$row_acciones[5]\"
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