<?php
    include '../global_seguridad/verificar_sesion.php';

    $cadena = "SELECT id, concepto, monto, 
                (SELECT nombre_emisor FROM detalle_control_gastos WHERE detalle_control_gastos.id = gastos.id_detalle_gasto),
                (SELECT nombre FROM rublos WHERE rublos.id = gastos.id_rublo),
                (SELECT nombre_rancho FROM ranchos WHERE ranchos.id = gastos.id_rancho) FROM gastos WHERE activo = '1'";
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo    = "";
    $numero    = 1;
    $documento = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar = "<a onclick='eliminar_gasto($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar = "<a onclick='editar_gasto($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $foto ='facturas/'.$row[0].'.pdf';
    if (file_exists($foto)){
      $documento = "<a href='$foto' class='btn btn-danger'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></a>";
    }else{
      $documento = "<a href='#' class='btn btn-danger'><i class='fa fa-ban fa-lg' aria-hidden='true'></i></a>";
    }
                   

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Concepto\": \"$row[1]\",
      \"Monto\": \"$ $row[2]\",
      \"Rublo\": \"$row[4]\",
      \"Rancho\": \"$row[5]\",
      \"Fact\": \"$documento\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $documento = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>