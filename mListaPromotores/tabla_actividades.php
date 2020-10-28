<?php 
  include '../global_seguridad/verificar_sesion.php';

  $id_promotor = $_POST['id_promotor'];
  $fechaB      = $_POST['fecha'];
  
  $cadena   = "SELECT id, actividad FROM actividades_promotor WHERE id_promotor = '$id_promotor' AND activo = '1'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $actividad = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena2 = mysqli_query($conexion,"SELECT id, hora_inicio,hora_fin,comentario,cajas_surtidas FROM registro_actividades WHERE fecha = '$fechaB' AND id_actividad = '$row[0]' AND id_sucursal = '$id_sede'");
    $existe = mysqli_num_rows($cadena2);
    $row2   = mysqli_fetch_array($cadena2);
    $eliminar = "<button class='btn btn-danger' onclick='eliminar($row2[0])'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></button>";
    if($existe != 0){
      if($row2[3] == ""){
        $comentario = "<input type='text' onchange='actualizar_comentario(this.value,$row2[0])' value='' id='icomentario$numero' class='form-control' style='width:100%'>";
      }else{
        $comentario = "<p id='bcomentario$numero' ondblclick='comentario($numero)'>$row2[3]</p><input type='text' onchange='actualizar_comentario(this.value,$row2[0])' value='$row2[3]' id='icomentario$numero' class='form-control hidden' style='width:100%'>";
      }
      if($row2[4] != ""){
        $cajas = "<p id='bcajas$numero' ondblclick='cajas($numero)'>$row2[4]</p><input type='text' onchange='actualizar_cajas(this.value,$row2[0])' value='$row2[4]' id='icajas$numero' class='form-control hidden' style='width:100%'>";
      }else{
        $cajas = "";
      }
      $boton_hora1 = "<p id='bhora1$numero' ondblclick='act_hora1($numero)'>$row2[1]</p><input type='text' onchange='actualizar(this.value,$row2[0],1)' value='$row2[1]' id='ihora1$numero' class='form-control hidden'>";
      $boton_hora2 = "<p id='bhora2$numero' ondblclick='act_hora2($numero)'>$row2[2]</p><input type='text' onchange='actualizar(this.value,$row2[0],2)' value='$row2[2]' id='ihora2$numero' class='form-control hidden'>";
      $renglon = "
      {
      \"#\": \"$numero\",
      \"Actividad\": \"$row[1]\",
      \"HoraI\": \"$boton_hora1\",
      \"HoraF\": \"$boton_hora2\",
      \"Comentario\": \"$comentario\",
      \"Cajas\": \"$cajas\",
      \"Eliminar\": \"$eliminar\"
      },";
      $cuerpo = $cuerpo.$renglon;
      $numero ++;
    }
  }

  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>