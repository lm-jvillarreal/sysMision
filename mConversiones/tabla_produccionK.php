<?php
include '../global_seguridad/verificar_sesion.php';

$UnidadMedidaKilos = $_POST['UMKilos'];
$cadena  = "SELECT
turno,
subreceta,
harina_utilizada,
merma_masa,
merma_tortilla,
produccion_teorica,
usuario,
fechahora,
activo,
id
FROM
tor_bitacora_produccion  WHERE subreceta ='$UnidadMedidaKilos' AND activo = '1'";
           
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo         = "";
  $numero = 1;
  while ($row_acciones = mysqli_fetch_array($consulta)) 
  {
    if($row_acciones[0] == "1")
    {
      $turno = 'Matutino';
      //echo $turno;
    }else if($row_acciones[0] == "0"){
      $turno = 'Vespertino';
    }else{
      $turno = 'Vespertino';
    }
    $CadenaConversion = "SELECT masa, resultado FROM conversiones_tor WHERE conversion = '$row_acciones[1]'";
    $ConsultaConversion = mysqli_query($conexion, $CadenaConversion);
    $rowConversion = mysqli_fetch_array($ConsultaConversion);

    $inputHarinas = "<div class='input-group' style='width:100%''><input type='text' id='$row_acciones[0]' class='form-control' value='$row_acciones[2]'><span class='input-group-btn'><button id='btn_harina$row_acciones[0]' onclick='ActHarina($row_acciones[0],$row_acciones[2],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div> <input type='text'value='$row_acciones[0]' id='tiempo$numero'>";
    $inputMasas = "<div class='input-group' style='width:100%''><input type='text' id='$row_acciones[0]' class='form-control' value='$row_acciones[3]'><span class='input-group-btn'><button id='btn_merma_masa$row_acciones[0]' onclick='autorizar($row_acciones[0],$row_acciones[3],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div> <input type='hidden'value='$tiempo' id='tiempo$numero'>";
    $MermaTortillas = "<div class='input-group' style='width:100%''><input type='text' id='$row_acciones[0]' class='form-control' value='$row_acciones[4]'><span class='input-group-btn'><button id='btn_merma_tortilla$row_acciones[0]' onclick='autorizar($row_acciones[0],$row_acciones[4],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div> <input type='hidden'value='$tiempo' id='tiempo$numero'>";
    $ProduccionTeoricas = "<div class='input-group' style='width:100%''><input type='text' id='$row_acciones[0]' class='form-control' value='$row_acciones[5]'><span class='input-group-btn'><button id='btn_prodTeo$row_acciones[0]' onclick='autorizar($row_acciones[0],$row_acciones[5],$numero)' class='btn btn-danger' type='button'><i class='fa fa-floppy-o fa-lg' aria-hidden='true'></i></button></span></div> <input type='hidden'value='$tiempo' id='tiempo$numero'>";
    
    $TotalMasa = $row_acciones[2] * $rowConversion[0];
    //harina utilizada * masa (rendimientos)
    $MasaUsable = $TotalMasa - $row_acciones[3];
    //total de masa - merma masa
    $ProduccionTortilla = $MasaUsable/$rowConversion[1];
    //masa usable / resultado (conversiones)
    $ProdRealDiaria = $ProduccionTortilla - $row_acciones[4];
    //produccion Tortilla - merma tortilla
    $DiferenciaKilos = $ProdRealDiaria - $row_acciones[5];
    //produccion real diaria - produccion teorica

    $inputHarinaUtilizada = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$row_acciones[2]'></input></div>";
    $inputMermaMasa = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$row_acciones[3]'></input></div>";
    $MermaTortilla = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$row_acciones[4]'></input></div>";
    $ProduccionTeorica = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$row_acciones[5]'></input></div>";

    $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$valorPedido'></input></div>";
    $activo = ($row_acciones[2]=="8") ? "" : "checked";
    $editar = "<center><a href='#' onclick='editar($row_acciones[0])'>$row_acciones[0]</a></center>";
    $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='estatus($row_acciones[0])'></center>";
    $renglon = "
      {
      \"ID\": \"$row_acciones[9]\",
      \"turno\": \"$turno\",
      \"subreceta\": \"$row_acciones[1]\",
      \"harina\": \"$inputHarinaUtilizada\",
      \"total_masa\": \"$TotalMasa\",
      \"merma_masa\": \"$inputMermaMasa\",
      \"masa_usable\": \"$MasaUsable\",
      \"produccion_tortilla\": \"$ProduccionTortilla\",
      \"merma_tortilla\": \"$MermaTortilla\",
      \"produccion_teorica\": \"$ProduccionTeorica\",
      \"produccion_real\": \"$ProdRealDiaria\",
      \"diferencia\": \"$DiferenciaKilos\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;
 ?>