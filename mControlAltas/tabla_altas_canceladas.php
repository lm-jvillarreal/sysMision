<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
  
  $cadena  = "SELECT
                id,
                id_proveedor,
                ( SELECT CONCAT(personas.nombre,' ',personas.ap_paterno)
                  FROM usuarios
                  INNER JOIN personas ON personas.id = usuarios.id_persona
                  WHERE usuarios.id = altas_productos.usuario_proceso
                ) AS Usuario,
                iva,
                ieps,
                costo_final,
                fecha_proceso,
                fecha_libero,
                (SELECT nombre FROM sucursales WHERE sucursales.id = altas_productos.id_sucursal),
                comentario,
                clave_sat
              FROM
                altas_productos
              WHERE
                activo = '1'
              AND
                estatus = '3' ".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $clase  = "";
  $iva    = "";
  $ieps   = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    if($row[3] == "0"){
      $iva = "";
    }
    else{
      $iva = "IVA"; 
    }
    if($row[4] == "0"){
      $ieps = "";
    }
    else{
      $ieps = "IEPS"; 
    }

    if($ieps == "" && $iva == ""){
      $impuesto = "No Tiene";
    }else{
      $impuesto = "$ieps $iva";
    }

    $cadena_proveedores = "SELECT CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[1]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);
    $boton_ver = "<a onclick='mostrar_imagenes($row[0])' class='btn btn-danger'><i class='fa fa-file-image-o fa-lg'></i></a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Clave SAT\": \"$row[10]\",
      \"Proveedor\": \"$row_proveedores[0]\",
      \"Comprador\": \"$row[2]\",
      \"Costo\": \"$row[5]\",
      \"Impuesto\": \"$impuesto\",
      \"FechaP\": \"$row[6]\",
      \"FechaL\": \"$row[7]\",
      \"Sucursal\": \"$row[8]\",
      \"Comentario\": \"$row[9]\",
      \"Imagen\": \"$boton_ver\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $clase = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>