<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';

  $filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";
  
  $cadena  = "SELECT
                altas_productos.id,
                altas_productos.id_proveedor,
                altas_productos.costo,
                altas_productos.fecha,
                altas_productos.folio,
                altas_productos.iva,
                altas_productos.ieps,
                altas_productos.img_presentacion,
                altas_productos.img_codigo,
                altas_productos.clave_sat,
                altas_productos.costo_final,
                CONCAT(personas.nombre,' ',personas.ap_paterno) as UA,
                (SELECT nombre FROM sucursales WHERE sucursales.id = personas.id_sede) AS Suc
              FROM altas_productos 
                INNER JOIN usuarios ON usuarios.id = altas_productos.id_usuario
                INNER JOIN personas ON personas.id = usuarios.id_persona
              WHERE altas_productos.activo = '1' AND altas_productos.estatus = '0' ".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $clase = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena_proveedores = "SELECT CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$row[1]'";
    $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
    oci_execute($consulta_proveedores);
    $row_proveedores=oci_fetch_row($consulta_proveedores);

    $boton_eliminar = "<center><a onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a><center>";
    $boton_editar   = "<center><a class='btn btn-warning' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></a></center>";
    if($row[7] == "" && $row[8] == ""){
      $clase = "disabled";
    }

    $liberar = "<center><input type='checkbox' onchange='liberar($row[0])' ".$clase."></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Clave SAT\": \"$row[9]\",
      \"Proveedor\": \"$row_proveedores[0]\",
      \"Usuario Alta\": \"$row[11]\",
      \"Sucursal\": \"$row[12]\",
      \"Costo\": \"$$row[10]\",
      \"Fecha\": \"$row[3]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\",
      \"Liberar\": \"$liberar\"
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