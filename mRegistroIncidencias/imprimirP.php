<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';

  $id =  $_GET['id_registro'];

  $cadena_consulta = "SELECT
  incidencias.id,
  incidencias.nombre,
  CONCAT(promotores.nombre,' ',promotores.ap_paterno),
  promotores.compañia,
  incidencias.activo,
  incidencias.comentario,
  catalogo_incidencias.incidencia,
  categorias.categoria,
  incidencias.folio,
  incidencias.vigilante,
  CONCAT(vidvig_vigilantes.NOMBRE,' ',vidvig_vigilantes.AP_PATERNO,' ',vidvig_vigilantes.AP_MATERNO),
  incidencias.autorizacion,
  incidencias.accion,
	incidencias.empleado
  FROM
  incidencias,
  catalogo_incidencias,
  categorias,
  vidvig_vigilantes,
  promotores
  WHERE
  incidencias.categoria = categorias.id
  and incidencias.nombre=promotores.id
  AND incidencias.incidencia = catalogo_incidencias.id 
  AND incidencias.activo = '1'
  and incidencias.vigilante= vidvig_vigilantes.ID
  and incidencias.folio <'3'
  and incidencias.perfil ='2'
  ORDER BY id DESC
  AND incidencias.id= '$id'";

  $consulta_folio = mysqli_query($conexion, $cadena_consulta);
  $row_folio = mysqli_fetch_array($consulta_folio);

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
    width: 75px;
    max-width: 75px;
  }
  
  td.cantidad,
  th.cantidad {
    width: 40px;
    max-width: 40px;
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
    width: 270px;
    max-width: 270px;
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
      
          <td align='left'><b>Nombre:</b> <?php echo $row_folio[2]; ?></td><br>
     </tr>
     <tr>
          <td align='left'><b>Compañía:</b> <?php echo $row_folio[3]; ?></td>
      </tr>
      <tr>
          <td colspan="2"><b>Categoría: </b><?php echo $row_folio[7]; ?></td>
      </tr>
      <tr>
          <td colspan="2"><b>Incidencia: </b><?php echo $row_folio[6]; ?></td>
      </tr>
      <tr>
        <td colspan="2"><b>Accion Sugerida:</b> <?php echo $row_folio[12]; ?></td>
      </tr>
      <tr>
          <td colspan="2"><b>Comentario:</b><br><?php echo $row_folio[5]; ?></td>
      </tr>
      <tr>
          <td colspan="2"><b>Vigilante: </b><?php echo $row_folio[10]; ?></td>
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