<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
catalogo_incidencias.id_incidencia,
catalogo_incidencias.nombre as incidencia,
catalogo_formatos.nombre as categoria,
catalogo_incidencias.gravedad,
sanciones_incidencias.nombre as accion,
catalogo_incidencias.activo
FROM
catalogo_incidencias ,
catalogo_formatos ,
sanciones_incidencias
WHERE
catalogo_incidencias.categoria = catalogo_formatos.id AND
catalogo_incidencias.accion = sanciones_incidencias.id";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_incidencias[3]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_incidencias[0])'></center>";
    $renglon = "
      {
      \"id_incidencia\": \"$editar\",
      \"nombre\": \"$row_incidencias[1]\",
      \"categoria\": \"$row_incidencias[2]\",
      \"gravedad\": \"$row_incidencias[3]\",
      \"accion\": \"$row_incidencias[4]\",
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