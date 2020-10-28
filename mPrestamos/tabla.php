<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";
    // $filtro_sucursal = ($solo_sucursal=='1') ? " AND cajas.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT id,
                  ( SELECT nombre FROM sucursales WHERE sucursales.id = prestamos.id_sucursal ),
                  persona,
                  fecha_entrega
                FROM prestamos
                WHERE activo = '1'".$filtro;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_eliminar="<center><button type='button' onclick='eliminar($row[0])' class='btn btn-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button></center>";
    $boton_editar="<center><button type='button' onclick='editar($row[0])' class='btn btn-warning btn-sm'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";
    $boton_pdf="<center><a href='prestamo_pdf.php?id=$row[0]' class='btn btn-danger btn-sm' target='blank'><i class='fa fa-file-pdf-o fa-lg' aria-hidden='true'></i></a></center>";

    $renglon = "
      {
      \"#\": \"$numero\",
      \"Sucursal\": \"$row[1]\",
      \"Persona\": \"$row[2]\",
      \"Fecha\": \"$row[3]\",
      \"Editar\": \"$boton_editar\",
      \"Eliminar\": \"$boton_eliminar\",
      \"PDF\": \"$boton_pdf\"
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