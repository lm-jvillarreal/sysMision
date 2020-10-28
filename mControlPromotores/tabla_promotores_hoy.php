<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date("Y-m-j");
  $hora  = date('H:i:s');
  
  $cadena   = "SELECT
                  agenda_promotores.id,
                  CONCAT(promotores.nombre,' ',promotores.ap_paterno) AS Nombre,
                  promotores.compañia,
                  promotores.telefono,
                  agenda_promotores.hora_inicio,
                  agenda_promotores.hora_fin,
                  agenda_promotores.id_promotor
                FROM agenda_promotores
                INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                WHERE promotores.activo = '1'
                AND dia = '$fecha' AND id_sucursal = '$id_sede'";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $numero    = 1;
  $hora1     = "";
  $hora2     = "";
  $texto     = "";
  $color     = "";
  $disabled2 = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $hora1 = substr($row[4], 0,5);
    $hora2 = substr($row[5], 0,5);

    $cadena_veri = mysqli_query($conexion,"SELECT id,hora_entrada,hora_salida FROM registro_entrada WHERE id_promotor = '$row[6]' AND fecha = '$fecha'");
    $existe_promotor = mysqli_num_rows($cadena_veri);
    $row_v = mysqli_fetch_array($cadena_veri);
    if ($existe_promotor == 0){
      $color = "danger";
      $texto = "Iniciar";
      $disabled  = "disabled = 'disabled'";
      if($hora >= $row[4] && $hora <= $row[5]){
        $disabled2 = "";
      }else{
        $disabled2 = "disabled = 'disabled'";
      }
    }else{
      if($row_v[1] != "" && $hora <= $row[5]){
        $disabled = "disabled = 'disabled'";
      }else{
        $disabled = "";
      }
      $color = "warning";
      $texto = "Iniciado";
    }
    $boton1 = "<button class='btn btn-danger' $disabled onclick='salida_promotor($row[6])'>Terminar</button>";
    $boton = "<button class='btn btn-$color' $disabled2 href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default' target='blank'>$texto</button>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Compañia\": \"$row[2]\",
      \"Telefono\": \"$row[3]\",
      \"Horario\": \"$hora1 - $hora2\",
      \"Iniciar\": \"$boton\",
      \"Terminar\": \"$boton1\"
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