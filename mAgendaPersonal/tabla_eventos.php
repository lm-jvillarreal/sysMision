<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $fecha_Inicio = $_POST['fecha_inicial'];
  $fecha_Final = $_POST['fecha_final'];

  $filtro=(!empty($registros_propios) == '1')?"WHERE id_usuario = '$id_usuario'":"";

  $folio   = "";
  $cadena  = "";
  $cadena2 = "";

  $cadena  = "SELECT title,DATE_FORMAT(start, '%d-%m-%Y'),DATE_FORMAT(end, '%d-%m-%Y'),start,end,id,folio FROM agenda ". $filtro." AND fecha BETWEEN '$fecha_Inicio' AND '$fecha_Final' ORDER BY id DESC";
  
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo         = "";
  $total          = 0;
  $numero         = 1;
  $boton_eliminar = "";
  $titulo         = "";
  $invitados      = "";
  $numero_inv     = 1;

  while ($row_agenda = mysqli_fetch_array($consulta)) 
  {
    $cadena_invitados = mysqli_query($conexion,"SELECT u.id,CONCAT(p.nombre,' ',p.ap_paterno) FROM agenda a INNER JOIN usuarios u ON u.id = a.id_usuario INNER JOIN personas p ON p.id = u.id_persona WHERE a.folio = '$row_agenda[6]'");
    $cantidad_usuarios = mysqli_num_rows($cadena_invitados);
    while($row_usuarios = mysqli_fetch_array($cadena_invitados)){
      if ($cantidad_usuarios == 1){
        $invitados = "Añadir...";
      }
      else{
        if ($row_usuarios[0] == $id_usuario){}
        else{
          if ($numero_inv == $cantidad_usuarios){
            $invitados .= $row_usuarios[1];
          }
          else{
            $invitados .= $row_usuarios[1].', ';
          }
        }
      }
      $numero_inv ++;
    }

    $titulo = $row_agenda[0];
    $fecha1 = substr($row_agenda[3],0,10);
    $fecha2 = substr($row_agenda[4],0,10);

    $boton_nombre = "<p id='bnombre$numero' ondblclick='act_nombre($numero)'>$row_agenda[0]</p><input type='text' value='$row_agenda[0]' onblur='act_nom(this.value,$row_agenda[5])' id='input_nombre$numero' class='form-control hidden'>";
    $boton_fecha1 = "<p id='bfecha1$numero' ondblclick='act_fecha1($numero)'>$row_agenda[1]</p><input type='text' onblur='actualizar1(this.value,$row_agenda[5])' value='$fecha1' id='ifecha1$numero' class='form-control hidden'>";
    $boton_fecha2 = "<p id='bfecha2$numero' ondblclick='act_fecha2($numero)'>$row_agenda[2]</p><input type='text' onblur='actualizar2(this.value,$row_agenda[5])' value='$fecha2' id='ifecha2$numero' class='form-control hidden'>";
    $boton_invitar = "<form id='select$numero'><input type='text' value='$row_agenda[6]' id='folio' name='folio' class='hidden'><p id='inv$numero' ondblclick='act_inv($numero,$row_agenda[6])'>$invitados</p><select class='form-control hidden' multiple style='width: 100%' id='sinv$numero' name='invitados[]'></select><a class='btn btn-danger' onclick='add_invi($numero)' id='boton$numero' style='display:none'>Guardar</a></form>";
    $boton_eliminar = "<button class='btn btn-danger' onclick='eliminar($row_agenda[5])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre Evento\": \"$boton_nombre\",
      \"Fecha Inicio\": \"$boton_fecha1\",
      \"Fecha Final\": \"$boton_fecha2\",
      \"Invitados\": \"$boton_invitar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $invitados = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>