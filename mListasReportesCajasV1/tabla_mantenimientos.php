<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
  
  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

  $cadena  = "SELECT id,
                (SELECT nombre FROM sucursales WHERE sucursales.id = cajas_mantenimiento_equipos.id_sucursal),
                (SELECT nombre FROM cajas WHERE cajas.id = cajas_mantenimiento_equipos.id_caja),
                (SELECT nombre FROM cajas_catalogo_equipos WHERE cajas_catalogo_equipos.id = cajas_mantenimiento_equipos.id_equipo),comentario, fecha,
                (SELECT CONCAT(personas.nombre, ' ', personas.ap_paterno, ' ', personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = cajas_mantenimiento_equipos.id_usuario)
              FROM cajas_mantenimiento_equipos WHERE activo = '1'". $filtro;
  $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $activo = "";
    $imagenes = "";
    $gasto = "";
    $boton_comentario = "";
    $ruta = "";
    $ruta2 = "";
    $color = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $texto = $row[1].'-'.$row[2];

    $total_imagenes = count(glob("../mReporteCaja/imagesA/".$row[0]."/{*.jpg,*.jpeg,*.png}",GLOB_BRACE));
    for ($i=1; $i < $total_imagenes ; $i++) { 
      if (file_exists('../mReporteCaja/imagesA/'.$row[0].'/'.$i.'.jpg')){
        // echo "si";
        $ruta = '../mReporteCaja/imagesA/'.$row[0].'/'.$i.'.jpg';
        $imagenes .= "<a class='venobox hidden' href='$ruta' alt='Imagen $i' data-gall='myGallery_$numero' title='$texto'>$i</a>";
      }else{
        // echo "no";
        $ruta = '../mReporteCaja/imagesA/'.$row[0].'/'.$i.'.jpeg';
        $imagenes .= "<a class='venobox hidden' href='$ruta' alt='Imagen $i' data-gall='myGallery_$numero' title='$texto'>$i</a>";
      }
    }
    if (file_exists('../mReporteCaja/imagesA/'.$row[0].'/0.jpg')){
      $ruta2 = '../mReporteCaja/imagesA/'.$row[0].'/0.jpg';
      $color = "success";
    }else if(file_exists('../mReporteCaja/images/'.$row[0].'/0.jpeg')){
      $ruta2 = '../mReporteCaja/imagesA/'.$row[0].'/0.jpeg';
      $color = "success";
    }else{
      $color = "warning";
    }
    
    $boton_ver="<a class='venobox btn btn-$color btn-sm' href='$ruta2' alt='Imagen 1' data-gall='myGallery_$numero' title='$texto'><i class='fa fa-file-image-o fa-lg'></i></a>";
    $boton_editar="<button onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $boton_eliminar="<button onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Sucursal\": \"$row[1]\",
      \"Caja\": \"$row[2]\",
      \"Equipo\": \"$row[3]\",
      \"Comentario\": \"$row[4]\",
      \"IMG\": \" $boton_ver $imagenes\",
      \"Fecha\": \" $row[5]\",
      \"Usuario\": \"$row[6]\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $ruta = "";
    $ruta2 = "";
    $imagenes = "";
    $color = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>
