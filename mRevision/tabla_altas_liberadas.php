<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
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
                costo,
                fecha_proceso,
                fecha_libero,
                (SELECT nombre FROM sucursales WHERE sucursales.id = altas_productos.id_sucursal),
                comentario
              FROM
                altas_productos
              WHERE
                activo = '1'
              AND
                estatus = '2'";
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
      $iva = "No";
    }
    else{
      $iva = "Si"; 
    }
    if($row[4] == "0"){
      $ieps = "No";
    }
    else{
      $ieps = "Si"; 
    }

    $cadena_proveedores = "SELECT CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[1]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);
    $boton_ver = "<a onclick='mostrar_imagenes($row[0])' class='btn btn-danger'>Imagen</a>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row_proveedores[0]\",
      \"Comprador\": \"$row[2]\",
      \"Costo\": \"$row[5]\",
      \"IVA\": \"$iva\",
      \"IEPS\": \"$ieps\",
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