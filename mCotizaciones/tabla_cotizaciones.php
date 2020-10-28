<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $filtro=(!empty($registros_propios) == '1')?" AND cotizaciones.id_usuario = '$id_usuario'":"";
  $cadena = mysqli_query($conexion,"SELECT cotizaciones.id, nombre, fecha_cotizacion, (SELECT nombre FROM sucursales WHERE sucursales.id = cotizaciones.id_sucursal), proveedores_cotizacion.nombre_proveedor,proveedores_cotizacion.proveedor
  FROM cotizaciones
  LEFT JOIN proveedores_cotizacion ON proveedores_cotizacion.id = cotizaciones.proveedor_seleccionado
  WHERE cotizaciones.activo = '1'".$filtro);
  $cuerpo = "";
  $numero = 1;

  while($row = mysqli_fetch_array($cadena)){

    if($row[4] == ""){
      $cadena2 = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE pr.PROC_CVEPROVEEDOR = '$row[5]'";
      $consulta_proveedores = oci_parse($conexion_central, $cadena2);
      oci_execute($consulta_proveedores);
      $row_proveedores=oci_fetch_row($consulta_proveedores);
      $nombre_proveedor = $row_proveedores[1];
    }else{
      $nombre_proveedor = $row[4];
    } 
    $boton_eliminar = "<a onclick='eliminar_cotizacion($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_ver  = "<a class='btn btn-primary' onclick='ver_cotizacion($row[0])'><i class='fa fa-eye fa-lg' aria-hidden='true'></i></a>";
    
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Fecha\": \"$row[2]\",
      \"Sucursal\": \"$row[3]\",
      \"Proveedor\": \"$nombre_proveedor\",
      \"Eliminar\": \"$boton_eliminar\",
      \"Ver\": \"$boton_ver\"
      },";
    $cuerpo    = $cuerpo.$renglon;
    $numero ++;
    # Sumar el incremento para que en algún momento termine el ciclo
  }

  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
  ["
  .$cuerpo2.
  "]
  ";
  echo $tabla;

 ?>