<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
  $id_caja = $_POST['id_caja'];
  $cadena  = "SELECT id, (SELECT CONCAT(cajas.nombre,' - ',sucursales.nombre) FROM cajas 
  INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal WHERE reportes_cajas.id_caja = cajas.id),
                (SELECT equipo FROM detalle_caja WHERE reportes_cajas.id_equipo = detalle_caja.id),
                falla, status
                FROM reportes_cajas WHERE (status = '1' OR status = '2')";
  $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $activo = "";
    $icono = "";
    $color = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    if($row[4] == 1){
        // $icono = "clock-o";
        // $icono = "paper-plane";
      $texto = "Enviado";
      $color = "blue";
      $disabled = "";
    }else if($row[4] == 2){
      $texto = "Revisado";
      $color = "yellow";
      $disabled = "disabled";
    }else{
      $texto = "Reparado";
      $color = "green";
      $disabled = "disabled";
    }

    $boton_eliminar="<center><button type='button' $disabled onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    $boton_editar="<center><button type='button' $disabled onclick='editar($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $status = "<center><small class='label label-lg bg-$color'>$texto</small></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Caja\": \"$row[1]\",
      \"Equipo\": \"$row[2]\",
      \"Fallo\": \"$row[3]\",
      \"Status\": \"$status\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\"
      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>