<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $id_receta = $_POST['id_receta'];

  $cadena  = "SELECT catalogo.artc_articulo, catalogo.artc_descripcion, detalle.cantidad, catalogo.costo_total, IFNULL((detalle.cantidad*catalogo.costo_total),0), detalle.id 
              FROM cp_detalle_receta AS detalle INNER JOIN cp_productos AS catalogo ON detalle.artc_articulo = catalogo.artc_articulo
              WHERE detalle.id_receta = '$id_receta'";

  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo="";

  while ($rowDetalle = mysqli_fetch_array($consulta))
  {
    $cantidad = "<div class='input-group' style='width:100%''><input type='text' id='id_$rowDetalle[5]' class='form-control' value='$rowDetalle[2]'><span class='input-group-btn'><button onclick='cambiar_cantidad($rowDetalle[5])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
    $total = round($rowDetalle[4],2);
    $renglon = "
      {
        \"num\": \"$rowDetalle[5]\",
        \"codigo\": \"$rowDetalle[0]\",
        \"descripcion\": \"$rowDetalle[1]\",
        \"cantidad\": \"$cantidad\",
        \"costo_unitario\": \"$rowDetalle[3]\",
        \"total\": \"$total\"
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
