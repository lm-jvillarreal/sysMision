<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
  
  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

  $cadena  = "SELECT id, id_proveedor, nombre_encargado, fecha_servicio, gasto,(SELECT CONCAT(personas.nombre,' ', personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = bitacora_servicios.supervisor),(SELECT nombre FROM rublos WHERE rublos.id = bitacora_servicios.id_rublo),comentario,(SELECT sucursales.nombre FROM sucursales WHERE sucursales.id = bitacora_servicios.id_sucursal) FROM bitacora_servicios WHERE activo = '1' AND NOT EXISTS(SELECT NULL FROM detalle_pago_servicios WHERE detalle_pago_servicios.id_bitacora_servicio = bitacora_servicios.id AND activo = '1') ". $filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $imagenes = "";
  $gasto = "";
  $boton_comentario = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[1]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

    $total_imagenes = count(glob("images/".$row[0]."/{*.jpg,*.jpeg,*.png}",GLOB_BRACE));
    for ($i=1; $i < $total_imagenes ; $i++) { 
      if (file_exists('images/'.$row[0].'/'.$i.'.jpg')){
        // echo "si";
        $ruta = 'images/'.$row[0].'/'.$i.'.jpg';
        $imagenes .= "<a class='venobox hidden' href='$ruta' alt='Imagen $i' data-gall='myGallery_$numero' title='$row_proveedores[1]'>$i</a>";
      }else{
        // echo "no";
        $ruta = 'images/'.$row[0].'/'.$i.'.jpeg';
        $imagenes .= "<a class='venobox hidden' href='$ruta' alt='Imagen $i' data-gall='myGallery_$numero' title='$row_proveedores[1]'>$i</a>";
      }
    }
    if (file_exists('images/'.$row[0].'/0.jpg')){
      $ruta2 = 'images/'.$row[0].'/0.jpg';
      $color = "success";
    }else if(file_exists('images/'.$row[0].'/0.jpeg')){
      $ruta2 = 'images/'.$row[0].'/0.jpeg';
      $color = "success";
    }else{
      $color = "warning";
      $ruta2="";
    }
    $boton_ver="<a class='venobox btn btn-$color btn-sm' href='$ruta2' alt='Imagen 1' data-gall='myGallery_$numero' title='$row_proveedores[1]'><i class='fa fa-file-image-o fa-lg'></i></a>";
    $boton_editar="<button onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $boton_eliminar="<button onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_comentario = "<a href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default1' target='blank' class='btn btn-danger btn-sm'><i class='fa fa-commenting fa-lg' aria-hidden='true'></i></a>";
    $gasto = ($row[4] != "")?"$".$row[4]:"-";
    $acciones = "<center>$boton_ver $imagenes $boton_comentario $boton_editar $boton_eliminar</center";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row_proveedores[1]\",
      \"Encargado\": \"$row[2]\",
      \"Fecha\": \"$row[3]\",
      \"Gasto\": \" $gasto\",
      \"Sucursal\": \" $row[8]\",
      \"Comentario\": \"$row[7]\",
      \"Rublo\": \"$row[6]\",
      \"Imagenes\": \"$acciones\"
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
