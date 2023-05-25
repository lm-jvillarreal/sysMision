<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  include '../global_settings/consulta_sqlsrvr.php';

  $ide =  $_GET['id_registro'];

  $cadena_consulta = "SELECT
  incidencias.id,
  incidencias.nombre,
  incidencias.departamento,
  incidencias.incidencia,
  incidencias.sucursal,
  incidencias.activo,
  incidencias.comentario,
  catalogo_incidencias.incidencia,
  categorias.categoria,
  incidencias.folio,
  incidencias.vigilante,
  CONCAT(vidvig_vigilantes.NOMBRE,' ',vidvig_vigilantes.AP_PATERNO,' ',vidvig_vigilantes.AP_MATERNO),
  incidencias.accion,
  incidencias.empleado,
	incidencias.comentario_fin,
	CONCAT(p.nombre, ' ', p.ap_paterno,' ', p.ap_materno),
  DATE_FORMAT(incidencias.fecha, '%d/%m/%Y')
  FROM
  incidencias,
  catalogo_incidencias,
  categorias,
  vidvig_vigilantes,
	usuarios,
	personas p
  WHERE
  incidencias.categoria = categorias.id 
  AND incidencias.folio ='1'
  AND incidencias.incidencia = catalogo_incidencias.id 
  AND incidencias.activo = '1'
  and incidencias.vigilante= vidvig_vigilantes.ID
	and incidencias.usuario = usuarios.id
	and p.id=usuarios.id_persona
  AND incidencias.id= '$ide'";


  $consulta_folio = mysqli_query($conexion, $cadena_consulta);
  $row_folio = mysqli_fetch_array($consulta_folio);

  $cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_folio[1]'";
  $consulta_persona = sqlsrv_query($conn, $cadena_persona);
  $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
  $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
  $nombre_empleado=ucwords(strtolower($nombre_empleado));
  if($row_folio[13]==""){
    $empleado = $row_folio[1].'  '.$nombre_empleado;
  }else{
    $empleado = $row_folio[1].' '.$row_folio[13]; 
  }
  

?>
<!DOCTYPE html>
<html lang="es">
<head>
</head>
 <style>
  * {
    font-size: 13px;
    font-family: 'Arial';
  }
  td,
  th,
  tr,
  table {
    border-top: 0px;
    border-collapse: collapse;
  }
  
  td.producto,
  th.producto {
    width: 90px;
    max-width: 100px;
  }
  
  td.cantidad,
  th.cantidad {
    width: 50px;
    max-width: 50px;
    word-break: break-all;
  }
  
  td.precio,
  th.precio {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
  }
  
  .centrado {
    text-align: center;
    align-content: center;
    font-weight: bold;
  }
  
  .ticket {
    width: 300px;
    max-width: 400px;
  }
  
  img {
    max-width: inherit;
    width: inherit;
  }
  @media print{
    .oculto-impresion, .oculto-impresion *{
      display: none !important;
    }
  }
</style>
<body>
   <div style="padding: 5px; margin: 0px;" id="ticket" class="ticket">
    <p class="centrado">LA MISIÓN SUPERMERCADOS S.A DE C.V.
    <br>INCIDENCIAS</p>
    <table width='100%' border="0">
      <tr>
          <td align='left'>Se aplica el presente reporte a: <br><br><b><?php echo $empleado; ?></b><br> del departamento de:<b> <?php echo $row_folio[2]; ?><br><br></b>
          En la Sucursal: <b> <?php echo $row_folio[4]; ?></b> debido a: <br><b><?php echo $row_folio[7]; ?></b> <br><br></td>
      </tr>
      <tr>
      <td>
        Obteniendo una sanción de tipo: <b><?php echo $row_folio[12]; ?>.</b></td>
      </tr>
      <tr>
          <td colspan="2">Comentario Vigilante:<br><b><?php echo $row_folio[6]; ?></b><br><br></td>
      </tr>
      <tr>
          <td colspan="2">Fecha:<br><b><?php echo $row_folio[16]; ?></b><br><br></td>
      </tr>
      <tr>
          <td colspan="2">Comentario Gerente:<br><b><?php echo $row_folio[14]; ?></b><br><br></td>
      </tr>
      <tr>
          <td>Gerente: <b><?php echo $row_folio[15]; ?></b><br></td>
      </tr>
      <tr>
          <td colspan="2">Vigilante: <b><?php echo $row_folio[11]; ?></b></td>
      </tr>
    </table>
   </div>
   <button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
<script >
  function imprimir() {
      window.print();
 }
</script>
</body>
</html>