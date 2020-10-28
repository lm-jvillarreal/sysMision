<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT id_proveedor, nombre, razon_social, nombre_vededor, nombre_supervisor, tel_empresa, cel_vendedor, corr_vend FROM proveedores_mantenimiento WHERE activo = '1'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $compañero = "";
    $pieza = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $actividad = mysqli_real_escape_string($conexion, $row[1]);
    $boton_eliminar="<button type='button' onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
    $boton_editar="<button type='button' onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button>";
    $boton_ver="<button type='button' onclick='ver($row[0])' class='btn btn-info btn-sm'><i class='fa fa-eye fa-lg' aria-hidden='true'></i></button>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$actividad\",
      \"RSocial\": \"$row[2]\",
      \"NombVen\": \"$row[3]\",
      \"TelEmp\": \"$row[5]\",
      \"CelVen\": \"$row[6]\",
      \"CorrVen\": \"$row[7]\",
      \"Acciones\": \"$boton_editar $boton_eliminar $boton_ver\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $pieza = "";
    $compañero ="";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>