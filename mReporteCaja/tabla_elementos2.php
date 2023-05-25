<?php 
  include '../global_seguridad/verificar_sesion.php';
  
  $datos = array();
  $ide = $_GET['ide'];
  
  $cadena  = "SELECT
                dc.id_caja,
                te.id_tipo,
                te.nombre,
                dc.id 
              FROM
                detalle_caja dc
              INNER JOIN tipos_equipos te ON dc.id_equipo = te.id_tipo 
              WHERE
                dc.activo = '1' 
              AND dc.id_caja= '$ide'
              and dc.id_equipo = te.id_tipo";
  $numero = 1;
  $consulta = mysqli_query($conexion, $cadena);
  
  while ($row_1 = mysqli_fetch_array($consulta)) 
  {
    $funciona="<center><input type='checkbox' name='funciona' id='funciona' onclick='funcional($row_1[3],$row_1[1])'></center>";

    $combo="<select id='falla".$row_1[3]."' name='falla' class='form-control' style='width: 100%'onchange=asignaValor($row_1[3],$numero);></select><input id='selecciona_$numero' type='hidden' name='seleccionado[]' form='form_datos' value='0'><input type='hidden' id='id_falla$numero' name='id_fallas[]' form='form_datos' value='' class='botones'>";
    $nombre = $row_1[1]."&nbsp;".$row_1[2];
    array_push($datos,array(
      'equipo'=>$nombre,
      'funciona'=>$funciona,
      'combo'=>$combo

    ));
    $numero ++;
  }
  
  echo utf8_encode(json_encode($datos));
?>