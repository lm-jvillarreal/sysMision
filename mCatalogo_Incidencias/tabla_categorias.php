<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
categorias.id,
categorias.categoria,
categorias.usuario,
categorias.activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = categorias.usuario)
FROM
categorias";
// -- WHERE
// -- catalogo_claves$row_claves.categoria = catalogo_formatos.id AND
// -- catalogo_incidencias.accion = sanciones_incidencias.id
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_categoria = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_categoria[3]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editarCategorias($row_categoria[0])'>$row_categoria[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatusCategorias($row_categoria[0])'></center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"categoria\": \"$row_categoria[1]\",
      \"usuario\": \"$row_categoria[4]\",
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