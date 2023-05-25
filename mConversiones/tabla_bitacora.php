<?php
include '../global_seguridad/verificar_sesion.php';

$cadena  = "SELECT
id, turno, subreceta, produccion_teorica, harina_utilizada, merma_masa, merma_tortilla, usuario, fechahora, activo,
(SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = tor_bitacora_produccion.usuario), sucursal
FROM
tor_bitacora_produccion";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";


  while ($row_acciones = mysqli_fetch_array($consulta)) 
  {
    if($row_acciones[11]=="1"){
      $sucursal = "DIAZ ORDAZ";
    }else if($row_acciones[11]=="2"){
      $sucursal = "ARBOLEDAS";
    }else if($row_acciones[11]=="3"){
      $sucursal = "VILLEGAS";
    }else if($row_acciones[11]=="4"){
      $sucursal = "ALLENDE";
    }else if($row_acciones[11]=="5"){
      $sucursal = "PETACA";
    }else{
      $sucursal = "";
    }
    if($row_acciones[1] == "1")
    {
      $turno = 'Matutino';
      //echo $turno;
    }else if($row_acciones[1] == "0"){
      $turno = 'Vespertino';
    }else{
      $turno = "";
    }
    $activo = ($row_acciones[2]=="8") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_acciones[0])'>$row_acciones[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_acciones[0])'></center>";
    $imprimir = "<center><a href='#' onclick='imp_ficha($row_acciones[0])'>$row_acciones[0]</i></a></center>";
    // class='btn btn-aqua'><i class='fa fa-print fa-lg'
    $renglon = "
      {
      \"id\": \"$imprimir\",
      \"fecha\": \"$row_acciones[8]\",
      \"turno\": \"$turno\",
      \"sucursal\": \"$sucursal\",
      \"subreceta\": \"$row_acciones[2]\",
      \"produccion\": \"$row_acciones[3]\",
      \"masa\": \"$row_acciones[4]\",
      \"merma_masa\": \"$row_acciones[5]\",
      \"merma_tortilla\": \"$row_acciones[6]\",
      \"usuario\": \"$row_acciones[10]\"
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