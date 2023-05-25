<?php 
  include '../global_seguridad/verificar_sesion.php';
  $filtro=(!empty($registros_propios) == '1')?"AND control_equipos.id_usuario = '$id_usuario'":"";
  $datos = array();

  if(!empty($_POST['id_sucursal'])){
    $id_sucursal     = $_POST['id_sucursal'];
    $filtro_sucursal = " AND cajas.id_sucursal = '$id_sucursal'";
  }
  else{
    $filtro_sucursal = ""; 
  }
  
  $cadena  = "SELECT
                control_equipos.id,
                (
                  SELECT
                    marca
                  FROM
                    marcas
                  WHERE
                    marcas.id = control_equipos.id_marca
                ) AS Marca,
                (
                  SELECT
                    modelo
                  FROM
                    modelos
                  WHERE
                    modelos.id = control_equipos.id_modelo
                ) AS Modelo,
                (SELECT CONCAT(nombre,' ',(SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal)) FROM cajas WHERE cajas.id = control_equipos.id_caja),
                control_equipos.numero_serie,
                control_equipos.llave_banorte,
                control_equipos.afiliacion,
                control_equipos.tipo,
                control_equipos.id_caja
              FROM
                control_equipos
              INNER JOIN cajas ON cajas.id = control_equipos.id_caja
              WHERE
              control_equipos.activo = '1'".$filtro_sucursal.$filtro." ORDER BY cajas.nombre ASC";
              // echo $cadena;
  $consulta = mysqli_query($conexion, $cadena);

  $cuerpo = "";
  $numero = 1;
  $activo = "";
  $caja   = "";
  $color  = "";

  while ($row = mysqli_fetch_array($consulta)) 
  {
    $cadena_veri    = mysqli_query($conexion,"SELECT actualizo FROM historial_equipos WHERE id_caja = '$row[8]' AND actualizo <> '1'");
    $existe         = mysqli_num_rows($cadena_veri);
    $color = ($existe != "0")?"success":"primary";
    $boton_eliminar = "<a onclick='eliminar($row[0])' class='btn btn-danger'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a>";
    $boton_editar   = "<a class='btn btn-warning' onclick='editar_registro($row[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a>";
    $boton_falla    = "<a class='btn btn-".$color."' onclick='reporte($row[0])'><i class='fa fa-clipboard fa-lg' aria-hidden='true'></i></a>";

    array_push($datos,array(
      '#'=>$numero,
      'Marca'=>$row[1],
      'Modelo'=>$row[2],
      'NS'=>$row[4],
      'Llave'=>$row[5],
      'Caja'=>$row[3],
      'Afiliacion'=>$row[6],
      'Tipo'=>$row[7],
      'Editar'=>$boton_editar,
      'Eliminar'=>$boton_eliminar,
      'Reporte Falla'=>$boton_falla
    ));
     $numero ++;
  }

  echo utf8_encode(json_encode($datos));
?>