<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

  $id = $_POST['id'];
  $cadena  = "SELECT detalle_act_mant_piezas.id,descripcion 
                FROM detalle_act_mant_piezas
                INNER JOIN catalogo_piezas ON catalogo_piezas.id_cat = detalle_act_mant_piezas.id_pieza 
                WHERE detalle_act_mant_piezas.activo = '1' AND id_act_mant = '$id'".$filtro;
  $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {    
    $boton_eliminar="<center><button type='button' onclick='eliminar_pieza($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Nombre\": \"$row[1]\",
      \"Eliminar\": \"$boton_eliminar\"
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