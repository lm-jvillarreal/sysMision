<?php 
    include '../global_seguridad/verificar_sesion.php';
    $filtro=(!empty($registros_propios) == '1')?" AND hp.id_usuario = '$id_usuario'":"";
    $filtro_sucursal = ($solo_sucursal=='1') ? " AND p.id_sucursal='$id_sede'":"";
  
    $cadena  = "SELECT
                    hp.id,
                    p.persona,
                    (SELECT nombre FROM sucursales WHERE sucursales.id = p.id_sucursal ),
                    (SELECT descripcion FROM catalogo_piezas WHERE catalogo_piezas.codigo_interno = hp.codigo_interno ),
                    hp.cantidad,
                    p.fecha_entrega
                FROM historial_prestamos hp
                INNER JOIN prestamos p ON p.id = hp.id_prestamo
                WHERE hp.activo = '1' AND p.activo = '1'".$filtro.$filtro_sucursal;
    $consulta = mysqli_query($conexion, $cadena);

    $cuerpo = "";
    $numero = 1;
    $retardo = "";
  while ($row = mysqli_fetch_array($consulta)) 
  {
    $boton_liberar="<center><div class='input-group'><div class='input-group-btn'><button type='button' onclick='liberar($row[0],$numero)' class='btn btn-success'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i></button></div><input type='text' class='form-control' id='cant_$numero' placeholder='Piezas a Regresar'><input type='text' class='form-control hidden' id='limite_$numero' value='$row[4]'></div></center>";

    $retardo = ($fecha >= $row[5])?"<i class='fa fa-clock-o' aria-hidden='true'></i>":"";
    $renglon = "
      {
      \"#\": \"$numero\",
      \"Persona\": \"$row[1]\",
      \"Sucursal\": \"$row[2]\",
      \"Pieza\": \"$row[3]\",
      \"Cantidad\": \"$row[4]\",
      \"Fecha\": \"$row[5] $retardo\",
      \"Liberar\": \"$boton_liberar\"

      },";
    $cuerpo = $cuerpo.$renglon;
    $numero ++;
    $retardo = "";
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>