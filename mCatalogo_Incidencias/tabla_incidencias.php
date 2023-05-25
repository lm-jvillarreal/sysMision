<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
catalogo_incidencias.id,
catalogo_incidencias.incidencia,
(SELECT categoria FROM categorias WHERE categorias.id=catalogo_incidencias.categoria) AS categoria,
(SELECT nombre FROM sanciones_incidencias WHERE sanciones_incidencias.id = catalogo_incidencias.accion_sugerida) AS accion,
(SELECT gravedad FROM gravedad_incidencias WHERE gravedad_incidencias.id = catalogo_incidencias.gravedad) AS gravedad,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = catalogo_incidencias.usuario),
catalogo_incidencias.activo,
catalogo_incidencias.tipo,
tipos_incidencias.tipo
FROM
catalogo_incidencias,tipos_incidencias
where tipos_incidencias.id=catalogo_incidencias.tipo";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_incidencias[6]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editarIncidencias($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatusIncidencias($row_incidencias[0])'></center>";
    $renglon = "
      {
      \"id\": \"$editar\",
      \"incidencia\": \"$row_incidencias[1]\",
      \"categoria\": \"$row_incidencias[2]\",
      \"tipo\": \"$row_incidencias[8]\",
      \"gravedad\": \"$row_incidencias[4]\",
      \"accion_sugerida\": \"$row_incidencias[3]\",
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