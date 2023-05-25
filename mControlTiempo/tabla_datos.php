<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  
  $fecha_actual = date('Y-m-d');
  $id_persona   = $_POST['dato'];
  $cadena       = "";
  $valor        = "";

  $cadena_horas = mysqli_query($conexion,"SELECT tabla.Persona,tabla.Extra,tabla.Permiso,SEC_TO_TIME(tabla.Extra - tabla.Permiso)
                      FROM
                      (
                        SELECT
                            me_control_tiempos.id_persona AS Persona,
                            (
                            SELECT SUM(TIME_TO_SEC(diferencia))
                            FROM me_control_tiempos me1
                            WHERE activo = '1'
                            AND me1.id_persona = me_control_tiempos.id_persona
                            AND (me1.tipo = '1' OR me1.tipo = '5')
                            ) AS Extra,
                            (
                            SELECT SUM(TIME_TO_SEC(diferencia))
                            FROM me_control_tiempos me1
                            WHERE activo = '1'
                            AND me1.id_persona = me_control_tiempos.id_persona
                            AND (me1.tipo = '2' OR me1.tipo = '3')
                            ) AS Permiso
                        FROM me_control_tiempos
                        WHERE id_persona = '$id_persona'
                        GROUP BY id_persona
                      ) AS tabla");
  $row_hora = mysqli_fetch_array($cadena_horas);

  $cadena  = "SELECT id,fecha,hora_inicio,hora_fin,CASE
                tipo 
                WHEN '1' THEN
                'Extra' 
                WHEN '5' THEN
                'Extra'
                WHEN '2' THEN
                'Permiso' 
                ELSE 'Pagado'
              END AS tipo,
              diferencia,comentarios,activo,comentario_pagado FROM me_control_tiempos WHERE id_persona = '$id_persona' AND activo != '0' ORDER BY fecha DESC";

  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $numero    = 1;

  $boton_fecha       = "";
  $boton_hora_inicio = "";
  $boton_hora_fin    = "";
  $boton_tipo        = "";
  $boton_comentario  = "";
  $opciones          = "";
  $eliminar          ="";
  $pagar = "";

  while ($row_tiempo = mysqli_fetch_array($consulta)) 
  {
    $hora_ini   = substr($row_tiempo[2],0,5);
    $hora_fin   = substr($row_tiempo[3],0,5);
    $diferencia = substr($row_tiempo[5],0,5);

    if ($row_tiempo[4] == 'Extra'){
      $opciones = "<option value='1' selected>Extra</option>";
      $opciones .= "<option value='2'>Permiso</option>";
    }
    else{
      $opciones = "<option value='1'>Extra</option>";
      $opciones .= "<option value='2' selected>Permiso</option>"; 
    }

    $eliminar ="<button class='btn btn-danger' onclick='eliminar($row_tiempo[0],$id_persona)'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button><input type='text' id='id_persona_$numero' value='$id_persona' class='hidden'>";

    if($row_tiempo[4] == "Extra"){
      $boton_tipo = "<center><span class='badge bg-green'>Extra</span></center>";
      if($diferencia <=  $row_hora[3]){
        $pagar ="<div class='input-group margin'><input type='text' class='form-control' style='width:100%' placeholder='Comentario' id='comentario2_$numero'><div class='input-group-btn'><button type='button' class='btn btn-warning' onclick='pagar2($row_tiempo[0],$numero)'><i class='fa fa-money fa-sm' aria-hidden='true'></i></button></div></div>";
      }else{
        $pagar = "";
      }
    }else if($row_tiempo[4] == "Permiso"){
      $boton_tipo = "<center><span class='badge bg-red'>Permiso</span></center>";
    }else{
      $boton_tipo = "<center><span class='badge bg-yellow'>Pagado</span></center>";
    }

    if($row_tiempo[7] == 2){
      $cancelar = "<button type='button' class='btn btn-danger' onclick='cancelar_pago($row_tiempo[0],$numero)'><i class='fa fa-ban fa-sm' aria-hidden='true'></i></button>";
    }else{
      $cancelar = "";
    }
    $esc_desc = mysqli_real_escape_string($conexion, $row_tiempo[6]);
    $boton_fecha = ($row_tiempo[4] == "Pagado")?"$row_tiempo[1]":"<p id='bfecha$numero' ondblclick='activar_fecha($numero)'>$row_tiempo[1]</p><input type='text' value='$row_tiempo[1]' onblur='actualizar_fecha(this.value,$row_tiempo[0])' id='input_fecha$numero' class='form-control hidden'>";
    $boton_hora_inicio = ($row_tiempo[4] == "Pagado")?"$hora_ini":"<p id='bhoraini$numero' ondblclick='activar_horaini($numero)'>$hora_ini</p><input type='text' value='$hora_ini' onblur='actualizar_horaini(this.value,$row_tiempo[0])' id='input_horaini$numero' class='form-control hidden'>";
    $boton_hora_fin = ($row_tiempo[4] == "Pagado")?"$hora_fin":"<p id='bhorafin$numero' ondblclick='activar_horafin($numero)'>$hora_fin</p><input type='text' value='$hora_fin' onblur='actualizar_horafin(this.value,$row_tiempo[0],$numero)' id='input_horafin$numero' class='form-control hidden'>";
    $boton_comentario = ($row_tiempo[4] == "Pagado")?"$row_tiempo[6]":"<p id='bcomentario$numero' ondblclick='activar_comentario($numero)'>$esc_desc</p><input value='$esc_desc' id='input_comentario$numero' onblur='actualizar_comentario(this.value,$row_tiempo[0],$numero)' class='form-control hidden'>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Fecha\": \"$boton_fecha\",
      \"HoraI\": \"$boton_hora_inicio\",
      \"HoraF\": \"$boton_hora_fin\",
      \"Tipo\": \"$boton_tipo\",
      \"Diferencia\": \"$diferencia\",
      \"Comentario\": \"$boton_comentario\",
      \"Eliminar\": \"$eliminar $pagar $cancelar\"
      },";
    $cuerpo    = $cuerpo.$renglon;
    $numero ++;
    $opciones  = "";
    $pagar = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>