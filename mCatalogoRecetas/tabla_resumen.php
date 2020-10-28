<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $id_receta = $_POST['id_receta'];
  if($id_receta==0){
    $clausula = " WHERE activo='1'";
  }else{
    $clausula = " WHERE id_receta='$id_receta'";
  }
  $cadena  = "SELECT  id, 
                      codigo_receta, 
                      nombre_receta, 
                      round(costo,2), 
                      ROUND(margen_sugerido,2),
                      round(precio_sugerido,2),
                      margen_actual, 
                      round(pp_actual,2), 
                      DATE_FORMAT(fecha,'%d/%m/%Y'),
                      round(margen_operativo,2), 
                      round(costo_ingredientes,2) 
              from cp_resumen_receta".$clausula;

  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo="";
  while ($rowDetalle = mysqli_fetch_array($consulta))
  {
    $renglon = "
      {
        \"num\": \"$rowDetalle[0]\",
        \"codigo\": \"$rowDetalle[1]\",
        \"receta\": \"$rowDetalle[2]\",
        \"costo_ingredientes\": \"$rowDetalle[10]\",
        \"margen_operativo\": \"$rowDetalle[9]\",
        \"costo\": \"$rowDetalle[3]\",
        \"margen_sugerido\": \"$rowDetalle[4]\",
        \"pp_sugerido\": \"$rowDetalle[5]\",
        \"margen_actual\": \"$rowDetalle[6]\",
        \"pp_actual\": \"$rowDetalle[7]\",
        \"fecha\": \"$rowDetalle[8]\"
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
