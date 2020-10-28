<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT firmas.id,CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)AS Nomb,firmas.activo
              FROM firmas
              INNER JOIN personas ON personas.id = firmas.id_persona";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row_firmas = mysqli_fetch_array($consulta)) 
  {
    if($row_firmas[2] == 1){
      $activo = "<button class='btn btn-success'><i class='fa fa-refresh fa-lg' aria-hidden='true'></i></button>";
    }
    else{
      $activo = "<button class='btn btn-danger' onclick='activar($row_firmas[0]);'><i class='fa fa-refresh fa-lg' aria-hidden='true'></i></button>";
    }
    $estatus="<center>".$activo."</center>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Usuario\": \"$row_firmas[1]\",
      \"Activo\": \"$estatus\"
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