<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $cadena  = "SELECT id, 
                      numero_proveedor, 
                      proveedor, 
                      correo_vendedor, 
                      cedis,
                      (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas INNER JOIN usuarios ON personas.id=usuarios.id_persona WHERE usuarios.id = proveedores.id_comprador),
                      escarg
              FROM proveedores";
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo="";
  while ($row_proveedores = mysqli_fetch_array($consulta))
  {
    $escape_desc = mysqli_real_escape_string($conexion, $row_proveedores[2]);
    $escape_correo = mysqli_real_escape_string($conexion, $row_proveedores[3]);
    $editar = "<a href='#' onclick='datos_editar($row_proveedores[0])'>$row_proveedores[0]</a>";
    
    $prop = $row_proveedores[4]=='0' ? "" : "checked";
    $prop_escarg=$row_proveedores[6]=='0' || is_null($row_proveedores[6]) ? "" : "checked";
    $cedis = "<center><div class='form-check'><input type='checkbox' class='form-check-input' id='cedis' onchange='cambiar($row_proveedores[0])' $prop></div></center>";
    $escarg = "<center><div class='form-check'><input type='checkbox' class='form-check-input' id='escarg' onchange='escarg($row_proveedores[0])' $prop_escarg></div></center>";

    $renglon = "
      {
      \"#\": \"$editar\",
      \"clave\": \"$row_proveedores[1]\",
      \"proveedor\": \"$escape_desc\",
      \"correo\": \"$escape_correo\",
      \"comprador\":\"$row_proveedores[5]\",
      \"cedis\":\"$cedis\",
      \"escarg\":\"$escarg\"
      },";
    $cuerpo = $cuerpo.$renglon;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>
