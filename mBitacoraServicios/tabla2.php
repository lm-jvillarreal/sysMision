<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $id_pago = $_POST['id_pago'];

  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";

  if($id_pago == 0){
    $filtro1 = " AND NOT EXISTS (SELECT NULL FROM detalle_pago_servicios WHERE detalle_pago_servicios.id_bitacora_servicio = bitacora_servicios.id AND activo = '1')";
  }else{
    $filtro1 = "";
  }
  
  $cadena  = "SELECT id, id_proveedor, nombre_encargado, fecha_servicio, gasto,(SELECT CONCAT(personas.nombre,' ', personas.ap_paterno,' ',personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = bitacora_servicios.supervisor),(SELECT nombre FROM rublos WHERE rublos.id = bitacora_servicios.id_rublo),comentario,(SELECT sucursales.nombre FROM sucursales WHERE sucursales.id = bitacora_servicios.id_sucursal) FROM bitacora_servicios WHERE activo = '1'".$filtro1.$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo           = "";
  $numero           = 1;
  $activo           = "";
  $imagenes         = "";
  $gasto            = "";
  $boton_comentario = "";
  $color = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    if($id_pago == 0){
      $boton_seleccionar ="<button class='btn btn-default btn-sm selec' id='boton_$numero' onclick='seleccionar($numero)'><i class='fa fa-check fa-lg' aria-hidden='true'></i></button> <input id='selecciona_$numero' type='hidden' name='seleccionado[]' form='form_datos' value='0'> <input type='hidden' name='id_servicio[]' form='form_datos' value='$row[0]'>";
    }else{
      $cadena2 = mysqli_query($conexion,"SELECT id FROM detalle_pago_servicios WHERE id_bitacora_servicio = '$row[0]' AND id_pago = '$id_pago' AND activo = '1'");
      $cantidad = mysqli_num_rows($cadena2);
      if($cantidad == 0){
        $boton_seleccionar ="<button class='btn btn-default btn-sm selec' id='boton_$numero' onclick='seleccionar($numero)'><i class='fa fa-check fa-lg' aria-hidden='true'></i></button> <input id='selecciona_$numero' type='hidden' name='seleccionado[]' form='form_datos' value='0'> <input type='hidden' name='id_servicio[]' form='form_datos' value='$row[0]'>";
      }else{
        $boton_seleccionar ="<button class='btn btn-danger btn-sm selec' onclick='eliminar_detalle($row[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
      }
    }
    $cadena2 = "";
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
    }else if (file_exists('images/'.$row[0].'/0.jpeg')){
      $ruta2 = 'images/'.$row[0].'/0.jpeg';
      $color = "success";
    }else{
      $color = "warning";
      $ruta2="";
    }
    $boton_ver ="<a class='venobox btn btn-$color btn-sm' href='$ruta2' alt='Imagen 1' data-gall='myGallery_$numero' title='$row_proveedores[1]'><i class='fa fa-file-image-o fa-lg'></i></a>";
    $boton_editar ="<button onclick='editar($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></button>";
    
    $boton_comentario = "<a href='#' data-id = '$row[0]' data-toggle = 'modal' data-target = '#modal-default1' target='blank' class='btn btn-danger'><i class='fa fa-commenting fa-lg' aria-hidden='true'></i></a>";
    $gasto = ($row[4] != "")?$row[4]:"0";
    $gasto .= "<input type = 'hidden' id='gasto_$numero' value= '$gasto' name='gasto[]'>";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row_proveedores[1]\",
      \"Encargado\": \"$row[2]\",
      \"Fecha\": \"$row[3]\",
      \"Gasto\": \" $ $gasto\",
      \"Sucursal\": \" $row[8]\",
      \"Comentario\": \"$row[7]\",
      \"Seleccionar\": \"$boton_ver $imagenes $boton_seleccionar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $ruta = "";
    $ruta2 = "";
    $imagenes = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>