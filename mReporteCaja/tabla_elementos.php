<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
  $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";

	
  $datos = array();
  $ide_caja = $_POST['id_cajaas'];
  $ide_caja2 = $_POST['id_cajaas'];
  $cadena  = "SELECT
                dc.id_caja,
                te.id_tipo,
                te.nombre 
              FROM
                detalle_caja dc
                INNER JOIN tipos_equipos te ON dc.id_equipo = te.id_tipo 
              WHERE
                dc.activo = '1' 
                AND dc.id_caja = '$ide_caja2'";
  $numero = 1;
  $consulta = mysqli_query($conexion, $cadena);

  
 while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<a onclick='eliminar_caja($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar="<a onclick='editar_caja($row[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";

    array_push($datos,array(
      'equipo'=>$numero,
      'funciona'=>$row[1],
      'error'=>$row[2]

    ));
    $numero ++;
  }
  echo utf8_encode(json_encode($cadena));
?>


