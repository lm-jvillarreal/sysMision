<?php
    include '../global_seguridad/verificar_sesion.php';

    function imagen($imagen){
      if (strlen(stristr($imagen,'pdf'))>0) {
        $imagen = "file-pdf-o";
      }else if(strlen(stristr($imagen,'xlsx'))>0){
        $imagen = "file-excel-o";
      }else if(strlen(stristr($imagen,'docx'))>0){
        $imagen = "file-word-o";
      }else if(strlen(stristr($imagen,'pptx'))>0){
        $imagen = "file-powerpoint-o";
      }else if(strlen(stristr($imagen,'jpg'))>0){
        $imagen = "file-image-o";
      }else if(strlen(stristr($imagen,'png'))>0){
        $imagen = "file-image-o";
      }else{
        $imagen = "file-o";
      }
      return $imagen;
    }

    $cadena_detalle = mysqli_query($conexion,"SELECT 
                            id,
                            proveedor,
                            fecha_movimiento,
                            gasto,
                            (SELECT nombre FROM rublos WHERE rublos.id = gastos_sistemas.id_rublo),
                            documento,
                            comentario,
                            evidencia,
                            folio_factura,
                            (SELECT nombre FROM sucursales WHERE id=gastos_sistemas.id_sucursal)
                        FROM gastos_sistemas
                        WHERE activo = '1'");

    $cuerpo        = "";
    $numero        = 1;
    $imagen        = "";
    $docuemnto     = "";
    $imagen_evi    = "";
    $documento_evi =  "";
    $docs = "";
  while ($row = mysqli_fetch_array($cadena_detalle)) 
  {
    $imagen_evi = imagen($row[7]);
    $documento_evi = ($row[7]!="")?"<a href='$row[7]' target='_blank'><i class = 'fa fa-$imagen_evi fa-2x'style='color: #DF0101;'></i></a>":"";
    $imagen = imagen($row[5]);
    
    $ruta = ($row[5]!= "")?$row[5]:"#";
    $documento = "<a href='$ruta' target='_blank'><i class = 'fa fa-$imagen fa-2x'style='color: #DF0101;'></i></a>";
    $docs = "<center>".$documento." ".$documento_evi."</center>";
    $editar = "<button class='btn btn-warning' onclick='editar_gasto($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $eliminar = "<button class='btn btn-danger' onclick='eliminar_gasto($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    // $ruta = ($row[5] == "")?"":"<a href='$row[5]' target='_blank' class='btn btn-warning'>Documento</a>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row[1]\",
      \"Sucursal\": \"$row[9]\",
      \"Fecha_m\": \"$row[2]\",
      \"Gasto\": \"$ $row[3]\",
      \"Folio Factura\": \"$row[8]\",
      \"Rublo\": \"$row[4]\",
      \"Documento\": \"$docs\",
      \"Comentario\": \"$row[6]\",
      \"Editar\": \"$editar\",
      \"Eliminar\": \"$eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $imagen = "";
    $documento_evi= "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>