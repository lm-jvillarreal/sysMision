<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  $datos=array();
  $cadena  = "SELECT id, 
                      TRIM(numero_proveedor), 
                      proveedor,
                      correo_vendedor, 
                      cedis,
                      (SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) FROM personas INNER JOIN usuarios ON personas.id=usuarios.id_persona WHERE usuarios.id = proveedores.id_comprador),
                      escarg,
                      (SELECT TIPO_PROVEEDOR FROM categorias_proveedor WHERE ID=proveedores.tipo_proveedor)
              FROM proveedores";
  $consulta = mysqli_query($conexion, $cadena);
  $cuerpo="";
  while ($row_proveedores = mysqli_fetch_array($consulta))
  {
    $cadena_proveedores = "SELECT PR.PRON_ESTATUS FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR='$row_proveedores[1]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_prov=oci_fetch_row($consulta_proveedores);
    if($row_prov[0]=='1'){

    }else{
      $escape_desc = mysqli_real_escape_string($conexion, $row_proveedores[2]);
      $escape_correo = mysqli_real_escape_string($conexion, $row_proveedores[3]);
      $editar = "<a href='#' onclick='datos_editar($row_proveedores[0])'>$row_proveedores[0]</a>";
      
      $prop = $row_proveedores[4]=='0' ? "" : "checked";
      $prop_escarg=$row_proveedores[6]=='0' || is_null($row_proveedores[6]) ? "" : "checked";
      $cedis = "<center><div class='form-check'><input type='checkbox' class='form-check-input' id='cedis' onchange='cambiar($row_proveedores[0])' $prop></div></center>";
      $escarg = "<center><div class='form-check'><input type='checkbox' class='form-check-input' id='escarg' onchange='escarg($row_proveedores[0])' $prop_escarg></div></center>";
      $eliminar="<center><a href='#' onclick='eliminar($row_proveedores[0])'><i class='fa fa-trash fa-lg' style='color: red;' aria-hidden='true'></i></a></center>";
  
      array_push($datos,array(
        '#'=>$editar,
        'clave'=>$row_proveedores[1],
        'proveedor'=>$escape_desc,
        'correo'=>$escape_correo,
        'tipo'=>$row_proveedores[7],
        'comprador'=>$row_proveedores[5],
        'cedis'=>$cedis,
        'escarg'=>$escarg,
        'eliminar'=>$eliminar
      ));
    }
  }
  echo utf8_encode(json_encode($datos));
 ?>
