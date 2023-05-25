<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
  $cadena  = "SELECT id, tipo, status FROM reportes_cajas WHERE activo = 1 AND (status = '1' OR status = '2')";
  $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $activo = "";
    $icono = "";
    $color = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    if($row[2] == 1){
        // $icono = "clock-o";
        // $icono = "paper-plane";
      $texto = "Enviado";
      $color = "blue";
      $disabled = "";
    }else if($row[2] == 2){
      $texto = "Revisado";
      $color = "yellow";
      $disabled = "disabled";
    }else{
      $texto = "Reparado";
      $color = "green";
      $disabled = "disabled";
    }

    $filtro_tipo = ($row[1] == 1)?"(SELECT nombre FROM fallas_equipos WHERE fallas_equipos.id = reportes_cajas.id_falla )":"id_falla";

    $cadena2 = "SELECT (SELECT CONCAT(cajas.nombre, ' - ', sucursales.nombre) FROM cajas INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal WHERE cajas.id = reportes_cajas.id_caja), (SELECT CONCAT(cajas_catalogo_equipos.nombre,' - ', cajas_catalogo_equipos.descripcion) FROM cajas_catalogo_equipos WHERE cajas_catalogo_equipos.id = reportes_cajas.id_equipo), $filtro_tipo FROM reportes_cajas WHERE id = '$row[0]'";
    // echo $cadena2;

    $consulta2 = mysqli_query($conexion, $cadena2);
    $row2 = mysqli_fetch_array($consulta2);

    $boton_eliminar="<center><button type='button' $disabled onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    $boton_editar="<center><button type='button' $disabled onclick='editar($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $status = "<center><small class='label label-lg bg-$color'>$texto</small></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Caja\": \"$row2[0]\",
      \"Equipo\": \"$row2[1]\",
      \"Fallo\": \"$row2[2]\",
      \"Status\": \"$status\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $cadena2 = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>