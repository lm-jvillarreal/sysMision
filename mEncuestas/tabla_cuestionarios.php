<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $cadena  = "SELECT id,nombre,cantidad_encuestados,DATE_FORMAT(fecha_inicio,'%d/%m/%Y'),DATE_FORMAT(fecha_fin,'%d/%m/%Y'),fecha_inicio,fecha_fin,encuestados,folio FROM cuestionarios WHERE activo = '1' AND folio != '' GROUP BY folio";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $numero    = 1;
  $clase     ="";
  $restantes = 0;
  $boton_DO = "";
  $boton_ARB = "";
  $boton_VILL = "";
  $boton_ALL = "";
  $DO = 0;
  $ARB = 0;
  $VILL = 0;
  $ALL = 0;

  while ($row_cuestionario = mysqli_fetch_array($consulta)) 
  {
    $cadena_sucursales = mysqli_query($conexion,"SELECT id_sucursal FROM cuestionarios WHERE folio = '$row_cuestionario[8]'");

    while ($row_sucursales = mysqli_fetch_array($cadena_sucursales)) {
      if ($row_sucursales[0] == 1){
        $DO = 1;
      }
      else if ($row_sucursales[0] == 2){
        $ARB = 2;
      }
      else if ($row_sucursales[0] == 3){
        $VILL = 3;
      }
      else if ($row_sucursales[0] == 4){
        $ALL = 4;
      }
    }

    $restantes = $row_cuestionario[2] - $row_cuestionario[7];
    if ($fecha_actual >= $row_cuestionario[5] && $fecha_actual <= $row_cuestionario[6]){
      $clase = "";
    }
    else{
      //$clase = "disabled";
    }

    if($DO == 1){
      $boton_DO = "<a class='btn btn-primary ".$clase."' href='encuesta.php?id=$row_cuestionario[8]&id_sucursal=$DO'>DO</a>";
    }
    else{
      $boton_DO = "<a class='btn btn-primary ".$clase."' href='encuesta.php?id=$row_cuestionario[8]&id_sucursal=$DO'>DO</a>";
      //$boton_DO   = "<a class='btn btn-primary disabled' href='encuesta.php?id=$row_cuestionario[0]&id_sucursal=$DO'>DO</a>";
    }

    if ($ARB == 2){
      $boton_ARB  = "<a class='btn btn-danger ".$clase."' href='encuesta.php?id=$row_cuestionario[8]&id_sucursal=$ARB'>ARB</a>";
    }
    else{
      $boton_ARB  = "<a class='btn btn-danger disabled' href='encuesta.php?id=$row_cuestionario[0]&id_sucursal=$ARB'>ARB</a>"; 
    }

    if ($VILL == 3){
      $boton_VILL  = "<a class='btn btn-warning ".$clase."' href='encuesta.php?id=$row_cuestionario[8]&id_sucursal=$VILL'>VILL</a>";
    }
    else{
      $boton_VILL  = "<a class='btn btn-warning disabled' href='encuesta.php?id=$row_cuestionario[0]&id_sucursal=$VILL'>VILL</a>"; 
    }

    if ($ALL == 4){
      $boton_ALL  = "<a class='btn btn-success ".$clase."' href='encuesta.php?id=$row_cuestionario[8]&id_sucursal=$ALL'>ALL</a>";  
    }
    else{
      $boton_ALL  = "<a class='btn btn-success disabled' href='encuesta.php?id=$row_cuestionario[0]&id_sucursal=$ALL'>ALL</a>";   
    }
    
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row_cuestionario[1]\",
      \"FechaI\": \"$row_cuestionario[3]\",
      \"FechaF\": \"$row_cuestionario[4]\",
      \"Restantes\": \"$restantes\",
      \"DO\": \"$boton_DO\",
      \"ARB\": \"$boton_ARB\",
      \"VILL\": \"$boton_VILL\",
      \"ALL\": \"$boton_ALL\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $restantes = 0;

    $boton_DO   = "";
    $boton_ARB  = "";
    $boton_VILL = "";
    $boton_ALL  = "";
    $DO         = 0;
    $ARB        = 0;
    $VILL       = 0;
    $ALL        = 0;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>