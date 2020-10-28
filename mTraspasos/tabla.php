<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
                  id,
                  (SELECT nombre FROM sucursales WHERE sucursales.id = traspasos.id_sucursal_origen),
                  (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = traspasos.codigo_interno),
                  (SELECT nombre FROM sucursales WHERE sucursales.id = traspasos.id_sucursal_destino),
                  cantidad
                FROM traspasos 
                WHERE activo = '1'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<center><button type='button' onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    $boton_editar="<center><button type='button' onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"SucursalO\": \"$row[1]\",
      \"Pieza\": \"$row[2]\",
      \"SucursalD\": \"$row[3]\",
      \"Cantidad\": \"$row[4]\",
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