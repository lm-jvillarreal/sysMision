<?php 
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha_actual = date('Y-m-d');

  $datos=array();
  $id_marca = $_POST['id_marca'];
  
  $cadena  = "SELECT
      mo.id AS id_modelo,
      ma.marca AS nombre_marca,
      mo.modelo AS nombre_modelo 
    FROM
	    modelos mo
	  INNER JOIN marcas ma ON mo.id_marca = ma.id 
    WHERE
	    mo.id_marca = '$id_marca' 
	  AND mo.activo =1";
  $consulta = mysqli_query($conexion, $cadena);
  // echo "$id_marca";
  $opciones = "";

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  while ($row_modelo = mysqli_fetch_array($consulta)) 
  { 
   
    $boton_editar = "<a class='btn btn-warning' onclick='editar_modelo($row_modelo[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $boton_eliminar="<a onclick='eliminar_modelo($row_modelo[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";

    array_push($datos,array(
      '#'=>$numero,
      'Marca'=>$row_modelo[1],
      'Modelo'=>$row_modelo[2],
      'Editar'=>$boton_editar,
      'Eliminar'=>$boton_eliminar
    ));
    $numero ++;
  }
  echo utf8_encode(json_encode($datos));
?>