<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT id_permiso, nombre, activo FROM permisos "; //WHERE activo='1'          

$consulta_permisos = mysqli_query($conexion, $cadena);

$cuerpo = "";


while ($row_permisos = mysqli_fetch_array($consulta_permisos)) 
{
  $activo = ($row_permisos[2]=="0") ? "" : "checked";
  $editar = "<center><a href='#' onclick='editar($row_permisos[0])'>$row_permisos[0]</a></center>";
  
  $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_permisos[0])'></center>";

  $renglon = "
  {
    \"id\": \"$editar\",
    \"nombre\": \"$row_permisos[1]\",
      \"activo\": \"$chk_activo\"
    },";
  $cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>

