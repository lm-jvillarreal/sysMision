<?php 
  include '../global_seguridad/verificar_sesion.php';
  // $id_sede = '3';
  
  $filtro_sucursal = ($solo_sucursal == '1') ? " AND id_sucursal = '$id_sede'" : "";

  $cadena   = "SELECT agenda_promotores.id,
                  CONCAT(promotores.nombre,' ',promotores.ap_paterno) AS Nombre,
                  promotores.compañia,
                  promotores.telefono,
                  agenda_promotores.hora_inicio,
                  agenda_promotores.hora_fin,
                  agenda_promotores.id_promotor,
                  (SELECT nombre FROM sucursales WHERE sucursales.id = agenda_promotores.id_sucursal),
                  agenda_promotores.id_sucursal
                FROM agenda_promotores
                INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                WHERE promotores.activo = '1'
                AND dia = '$fecha'".$filtro_sucursal;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $numero    = 1;
  $hora1     = "";
  $hora2     = "";
  $texto     = "";
  $color     = "";
  $disabled2 = "";
  $disabled  = "";
  $tiempo    = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $hora1 = substr($row[4], 0,5);
    $hora2 = substr($row[5], 0,5);

    $cadVeri = "SELECT id,hora_entrada,hora_salida FROM registro_entrada WHERE id_promotor = '$row[6]' AND fecha = '$fecha' AND id_sucursal = '$row[8]'";
    $cadena_veri = mysqli_query($conexion,$cadVeri);
    
    //$existe_promotor = mysqli_num_rows($cadena_veri);
    $row_v = mysqli_fetch_array($cadena_veri);
    $existe_promotor=count($row_v[0]);
    if ($existe_promotor == 0){
      $color = "danger";
      $texto = "Iniciar";
      if($hora > $row[4]){
        $tiempo = "<i class='fa fa-clock-o fa-lg' aria-hidden='true'></i>";
      }
      $disabled = "disabled = 'disabled'";
    }elseif(is_null($row_v[2])){
      $color = "warning";
      $texto = "Iniciado";
    }elseif(!is_null($row_v[2])){
      $color = "success";
      $texto = "Finalizado";
      $disabled = "disabled = 'disabled'";
      $disabled2 = "disabled = 'disabled'";
    }
    $boton1 = "<button class='btn btn-danger' $disabled onclick='salida_promotor($row[6])'>Terminar</button>";
    $boton  = "<button class='btn btn-$color' $disabled2 href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default' target='blank'>$texto</button>";
    $renglon = "
      {
        \"#\": \"$numero\",
        \"Nombre\": \"$row[1]\",
        \"Compañia\": \"$row[2]\",
        \"Telefono\": \"$row[3]\",
        \"Horario\": \"$hora1 - $hora2  $tiempo\",
        \"Sucursal\": \"$row[7]\",
        \"Iniciar\": \"$boton\",
        \"Terminar\": \"$boton1\"
      },";
    $cuerpo     = $cuerpo.$renglon;
    $numero ++;
    $clase      = "";
    $cronometro = "";
    $disabled   = "";
    $disabled2  = "";
    $tiempo     = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>