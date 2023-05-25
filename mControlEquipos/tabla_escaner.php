<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?"AND equipos_escaner.id_usuario = '$id_usuario'":"";
  $datos = array();

  if(!empty($_POST['id_sucursal'])){
    $id_sucursal     = $_POST['id_sucursal'];
    $filtro_sucursal = " AND cajas.id_sucursal = '$id_sucursal'";
  }
  else{
    $filtro_sucursal = ""; 
  }
  
  $cadena  = "SELECT equipos_escaner.id,
                    (SELECT marca FROM marcas WHERE marcas.id = equipos_escaner.id_marca),
                    equipos_escaner.serie,
                    (SELECT modelo FROM modelos WHERE modelos.id = equipos_escaner.id_modelo),
                    (SELECT CONCAT(nombre,' ',(SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal)) FROM cajas WHERE cajas.id = equipos_escaner.id_caja),
                    equipos_escaner.class_no,
                    equipos_escaner.fecha_fabricacion,
                    equipos_escaner.no_serial,
                    equipos_escaner.ruta
              FROM
                equipos_escaner
              INNER JOIN cajas ON cajas.id = equipos_escaner.id_caja
              WHERE equipos_escaner.activo = '1'".$filtro_sucursal.$filtro." ORDER BY cajas.nombre ASC";
              // echo $cadena;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo    = "";
  $numero    = 1;
  $documento = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $documento = ($row[8] != "")?"<a href='$ruta' target='_blank'><i class = 'fa fa-file-pdf-o fa-2x'style='color: #DF0101;'></i></a>":"<i class = 'fa fa-file-o fa-2x'style='color: #DF0101;'></i>";
    $boton_eliminar = "<a onclick='eliminar_escaner($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_registro_escaner($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";

    array_push($datos,array(
      '#'=>$numero,
      'Marca'=>$row[1],
      'Modelo'=>$row[3],
      'Caja'=>$row[4],
      'Serie'=>$row[2],
      'Class'=>$row[5],
      'FF'=>$row[6],
      'NS'=>$row[7],
      'Factura'=>$documento,
      'Editar'=>$boton_editar,
      'Eliminar'=>$boton_eliminar
    ));
  //   $renglon = "
  //     {
  //     \"#\": \"$numero\",
  //     \"Marca\": \"$row[1]\",
  //     \"Modelo\": \"$row[3]\",
  //     \"Caja\": \"$row[4]\",
  //     \"Serie\": \"$row[2]\",
  //     \"Class\": \"$row[5]\",
  //     \"FF\": \"$row[6]\",
  //     \"NS\": \"$row[7]\",
  //     \"Factura\": \"$documento\",
  //     \"Editar\": \"$boton_editar\",
  //     \"Eliminar\": \"$boton_eliminar\"
  //     },";
  //   $cuerpo = $cuerpo.$renglon;
     $numero ++;
   }
  // $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  // $tabla = "
  //   ["
  //   .$cuerpo2.
  //   "]
  //   ";
  echo utf8_encode(json_encode($datos));
?>