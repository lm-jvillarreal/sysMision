<?php
include '../global_seguridad/verificar_sesion.php';

$filtro=(!empty($autorizacion) == '1');
$datos=array();
  if(!empty($_POST['folio']))
  {
    $folio = $_POST['folio'];
  }
  else
  {
    $folio = 0;
  }
$cadena  = "SELECT
i.id,
i.nombre,
i.departamento,
ci.nombre,
i.activo,
i.folio,
i.comentario
FROM incidencias i INNER JOIN catalogo_incidencias ci
WHERE i.incidencia= ci.id_incidencia".$filtro;

  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";

  while ($row_incidencias = mysqli_fetch_array($consulta)) 
  {
    $activo = ($row_incidencias[4]=="0") ? "" : "checked";
    $autorizacion = ($row_incidencias[5]=="0") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_incidencias[0])'>$row_incidencias[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_incidencias[0])'></center>";
    $chk_autorizacion = "<center><input type='checkbox' name='autorizacion' id='autorizacion' $autorizacion onchange='autorizacion($row_incidencias[0])'></center>";
    
    array_push($datos, array(
      'id'=>$editar,
      'nombre'=>$row_incidencias[1],
      'departamento'=>$row_incidencias[2],
      'incidencia'=>$row_incidencias[3],
      'comentario'=>$row_incidencias[6],
      'activo'=>$chk_activo
    ));
    // $renglon = "
    //   {
    //   \"id\": \"$editar\",
    //   \"nombre\": \"$row_incidencias[1]\",
    //   \"departamento\": \"$row_incidencias[2]\",
    //   \"incidencia\": \"$row_incidencias[3]\",
    //   \"comentario\": \"$row_incidencias[6]\",
    //   \"activo\": \"$chk_activo\"
    //   },";
    // $cuerpo = $cuerpo.$renglon;
  }
  // $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  // $tabla = "
  // ["
  // .$cuerpo2.
  // "]
  // ";
  // echo $tabla;
  echo utf8_encode(json_encode($datos));
 ?>