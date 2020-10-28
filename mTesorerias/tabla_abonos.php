<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $folio   = "";
  $cadena  = "";
  $cadena2 = "";
  $boton   = "";
  
  if(!empty($_POST['folio']))
  {
    $folio = $_POST['folio'];
  }

  if ($folio == ""){
    $cadena2 = "WHERE abonos.id_sucursal = '$id_sede'";
  }
  else{
    $cadena2 = "WHERE abonos.folio = '$folio'";
  }
  $cadena  = "SELECT abonos.abono,DATE_FORMAT(abonos.fecha, '%d/%m/%Y'),CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)AS Nom,abonos.id
                FROM abonos 
                INNER JOIN usuarios ON usuarios.id = abonos.id_usuario
                INNER JOIN personas ON usuarios.id_persona = personas.id AND abono != '0.00'".$cadena2;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $total  = 0;
  $numero = 1;

  while ($row_abonos = mysqli_fetch_array($consulta)) 
  {
    if($perfil_usuario == 1){
      $boton = "<label id='lblabono_$numero' ondblclick='mostrar($numero)'>$ $row_abonos[0]</label><input type='text' id='inputabono_$numero' class='form-control hidden' value='$row_abonos[0]' onchange='editar_abono($numero,$row_abonos[3])' style='width:100%'>";
    }else{
      $boton = "$row_abonos[0]";
    }
    

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Usuario\": \"$row_abonos[2]\",
      \"Cantidad\": \"$boton\",
      \"Fecha\": \"$row_abonos[1]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $total = 0;
    $boton = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>