<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
tipos_incidencias.id,
tipos_incidencias.tipo,
tipos_incidencias.activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = tipos_incidencias.usuario),
categorias.categoria
FROM
tipos_incidencias, categorias
where categorias.id = tipos_incidencias.categoria";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_tipos = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_tipos[2]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editarTipos($row_tipos[0])'>$row_tipos[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatusTipos($row_tipos[0])'></center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"tipo\": \"$row_tipos[1]\",
      \"categoria\": \"$row_tipos[4]\",
      \"usuario\": \"$row_tipos[3]\",
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