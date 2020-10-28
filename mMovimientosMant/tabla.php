<?php 
    include '../global_seguridad/verificar_sesion.php';
    // $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
                  id_entrada,
                  ( SELECT nombre FROM proveedores_mantenimiento WHERE proveedores_mantenimiento.id_proveedor = entradas.id_proveedor ),
                  orden_compra,
                  factura,
                  comentarios,
                  DATE_FORMAT(fecha, '%d-%m-%Y')
                FROM entradas
                WHERE activo = '1'
                ORDER BY fecha DESC";
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
      \"Proveedor\": \"$row[1]\",
      \"Orden\": \"$row[2]\",
      \"Factura\": \"$row[3]\",
      \"Comentarios\": \"$row[4]\",
      \"Fecha\": \"$row[5]\",
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