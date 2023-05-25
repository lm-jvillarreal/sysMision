<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');
  
  $datos=array();

  $cadena  = "SELECT
	marcas.id,
	marcas.marca,
	marcas.id_equipo,
	tipos_equipos.nombre 
FROM
	marcas,
	tipos_equipos 
WHERE
	marcas.activo = '1' 
	AND marcas.id_equipo = tipos_equipos.id_tipo";
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";

  while ($row_marca = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<a onclick='eliminar_marca($row_marca[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar="<a onclick='editar_marca($row_marca[0])' class='btn btn-warning'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $agregar="<a href='#' data-id = '$row_marca[0]' data-toggle = 'modal' data-target = '#modal-default2' class='btn btn-success' target='blank'> <i class='fa  fa-plus-square fa-lg'></i></a>";
    
    array_push($datos,array(
      '#'=>$numero,
      'Nombre'=>$row_marca[1],
      'Equipo'=>$row_marca[3],
      'Modelos'=>$agregar,
      'Editar'=>$boton_editar,
      'Eliminar'=>$boton_eliminar
    ));
    $numero ++;
  }
  echo utf8_encode(json_encode($datos));
?>