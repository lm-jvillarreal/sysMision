<?php 
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  if ($perfil_usuario == 1){
    $filtro = "";
  }
  else{
    $filtro = "AND id_comprador = '$id_persona'"; 
  }
  
  $cadena  = "SELECT
                id,
                id_proveedor,
                costo,
                fecha,
                folio,
                iva,
                ieps,
                img_presentacion,
                img_codigo,
                fecha_proceso,
                (
                  SELECT
                    CONCAT(
                      personas.nombre,
                      ' ',
                      personas.ap_paterno
                    )
                  FROM
                    usuarios
                  INNER JOIN personas ON personas.id = usuarios.id_persona
                  WHERE
                    usuarios.id = altas_productos.usuario_proceso
                ) AS UL,
                hora_proceso,
                (SELECT nombre FROM sucursales WHERE sucursales.id = altas_productos.id_sucursal)
              FROM
                altas_productos
              WHERE
                activo = '1'
              AND
                estatus = '1' ".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $clase  = "";
  $iva    = "No";
  $ieps   = "No";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    if($row[5] == "0"){
      $iva = "No";
    }
    else{
      $iva = "Si"; 
    }
    if($row[6] == "0"){
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
    $boton = "<select id='estatus$numero' class='form-control select2' onchange='abrir_comentario($numero)'><option value='0'>Selecciona una opcion</option><option value='2'>Liberar</option><option value='3'>Cancelar</option></select><input style='display:none' type='text' id='comentario$numero' class='form-control' onblur='cambiar_estatus(this.value,$row[0],$numero)'>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Proveedor\": \"$row_proveedores[0]\",
      \"Costo\": \"$row[2]\",
      \"IVA\": \"$iva\",
      \"IEPS\": \"$ieps\",
      \"FechaP\": \"$row[9]\",
      \"PersonaP\": \"$row[10]\",
      \"Sucursal\": \"$row[12]\",
      \"Boton\": \"$boton\",
      \"Imagen\": \"$boton_ver\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $clase = "";
    $iva   = "No";
    $ieps  = "No";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>