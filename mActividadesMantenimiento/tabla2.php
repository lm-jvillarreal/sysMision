<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

    $id = $_POST['id'];
    $cadena  = "SELECT id,(SELECT CONCAT(personas.nombre,' ',personas.ap_paterno, ' ', personas.ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = detalle_act_mant_compañeros.id_compañero)
                FROM detalle_act_mant_compañeros 
                WHERE activo = '1'AND id_act_mant = '$id'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {    
    $boton_eliminar="<center><button type='button' onclick='eliminar_compañero($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";

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