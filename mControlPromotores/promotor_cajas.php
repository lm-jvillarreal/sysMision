<?php 
  include '../global_seguridad/verificar_sesion.php';  
  $fecha1   = $_POST['fecha1'];
  $fecha2   = $_POST['fecha2'];
  $sucursal = $_POST['sucursal'];

  if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
    $filtro = "AND registro_actividades.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    $filtro2 = "AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
  }else{
    $filtro = "";
  }

  if(!empty($sucursal)){
    $filtro3 = " AND id_sucursal = '$sucursal'";
  }else{
    $filtro3 = "";
  }
  
  $cuerpo      = "";
  $numero      = 1;
  $promedio = 0;

  $cadena = mysqli_query($conexion,"SELECT id,CONCAT(nombre,' ',ap_paterno,' - ',compañia) FROM promotores WHERE activo = '1'");
  while ($row = mysqli_fetch_array($cadena)) {
      $nombre = $row[1];
      
      $cadena_actividades = mysqli_query($conexion,"SELECT SUM(cajas_surtidas) FROM actividades_promotor  LEFT JOIN registro_actividades ON registro_actividades.id_actividad = actividades_promotor.id WHERE id_promotor = '$row[0]'".$filtro.$filtro3);
      $row_act = mysqli_fetch_array($cadena_actividades);
      $cantidad_cajas = ($row_act[0] == "")?0:$row_act[0];

      $cadena_visitas = mysqli_query($conexion,"SELECT id FROM registro_entrada WHERE id_promotor = '$row[0]'".$filtro2.$filtro3);
      $cantidad_visitas = mysqli_num_rows($cadena_visitas);

      if($cantidad_cajas == 0 || $cantidad_visitas == 0){
        $promedio = 0;
      }else{
        $promedio = $cantidad_cajas / $cantidad_visitas;
        $promedio = round($promedio, 2);
      }

      $renglon = "
      {
      \"#\": \"$numero\",
      \"Promotor\": \"$row[1]\",
      \"Visitas\": \"$cantidad_visitas\",
      \"Cajas\": \"$cantidad_cajas\",
      \"Promedio\": \"$promedio\"
      },";

      $cuerpo         = $cuerpo.$renglon;
      $clase          = "";
      $cronometro     = "";   
      $nombre         = "";
      $cantidad_cajas = 0;
      $promedio       = 0;
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