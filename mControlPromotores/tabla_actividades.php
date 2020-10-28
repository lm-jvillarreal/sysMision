<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date("Y-m-j");
  $hora_actual  = date('H:i:s');
  $hora_actual = substr($hora_actual,0,-1);
  // echo $hora_actual;
  
  $id_promotor  = $_POST['id_promotor'];
  
  $cadena   = "SELECT id,actividad,principal FROM actividades_promotor WHERE activo = '1' AND id_promotor = '$id_promotor'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo      = "";
  $numero      = 1;
  $dato        = 0;
  $clase       = "";
  $clase2      = "";
  $hora_inicio = "";
  $cajas       = 0;

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cronometro  = "00:00:00";
    $cadena2 = mysqli_query($conexion,"SELECT id,hora_inicio,fecha,hora_fin,duracion,cajas_surtidas,comentario FROM registro_actividades WHERE id_actividad = '$row[0]'");
    $existe = mysqli_num_rows($cadena2);
    $texto = "";
    $evento = "";
    $evento1 = "";
    
    if($existe != 0){
      
      $row_registro = mysqli_fetch_array($cadena2);
      $clase2 = "";
      $texto = $row_registro[6];

      $fecha_completa_bd = $row_registro[2].' '.$row_registro[1];
      $fecha_completa_actual = $fecha_actual.' '.$hora_actual;

      $fecha1 = new DateTime($fecha_completa_bd);//fecha inicial
      $fecha2 = new DateTime($fecha_completa_actual);//fecha de cierre

      $intervalo = $fecha1->diff($fecha2);

      $cronometro = $intervalo->format('%H:%i:%s');

      if($row_registro[5] != ""){
        $cajas = $row_registro[5];
      }
      else{
        $cajas = 0;
      }
      if ($row_registro[3] != ""){
        $boton = "<a class='btn btn-warning'>Terminado</a>";
        $cronometro = $row_registro[4];
      }
      else{
        $boton = "<a onclick='iniciar($row[0])' class='btn btn-danger'>Terminar</a>";
      }
      $evento = "onblur='act_cajas(this.value,$row_registro[0])'";
      $evento1 = "onchange='act_comentario(this.value,$row_registro[0])'";
    }
    else{
      $clase2 = "disabled";
      $boton = "<a onclick='iniciar($row[0])' class='btn btn-success'>Iniciar</a>";
    }

    if($row[2] == 0){
      $clase = "disabled";
      $valor = "";
    }
    else{
      $clase = "";
      $valor = "value='$cajas'";
    }

    $cantidad_cajas = "<input type='number' $evento  $valor id='cajas".$numero."' class='form-control' ".$clase.' '. $clase2.">";
    $comentario     = "<input type='text' $evento1 id='comentario".$numero."' class='form-control' ".$clase2." value='$texto'>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Actividad\": \"$row[1]\",
      \"Boton\": \"$boton\",
      \"Cronometro\": \"$cronometro\",
      \"CantidadC\": \"$cantidad_cajas\",
      \"Comentario\": \"$comentario\"
      },";
    $cuerpo     = $cuerpo.$renglon;
    $numero ++;
    $clase      = "";
    $cronometro = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>