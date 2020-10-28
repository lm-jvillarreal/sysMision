<?php
  include '../global_seguridad/verificar_sesion.php';
  $oc =  $_GET['foc'];

  $cadena_consulta = "SELECT sucursales.nombre, 
                            libro_diario.numero_nota, 
                            CONCAT(proveedores.numero_proveedor,proveedores.proveedor), 
                            libro_diario.numero_factura, 
                            date_format(libro_diario.fecha, '%d/%m/%Y'), 
                            libro_diario.observaciones, 
                            libro_diario.total, 
                            libro_diario.usuario
  FROM libro_diario
  INNER JOIN sucursales ON libro_diario.sucursal = sucursales.id
  INNER JOIN proveedores ON libro_diario.id_proveedor =  proveedores.numero_proveedor
  WHERE libro_diario.orden_compra = '$oc' order by libro_diario.id desc limit 1";

  $consulta_folio = mysqli_query($conexion, $cadena_consulta);
  $row_folio = mysqli_fetch_array($consulta_folio);
  $total = money_format('%(#10n', $row_folio[6]);

  $cadena_recibe = "SELECT CONCAT(p.nombre,' ',p.ap_paterno,' ',p.ap_materno) FROM personas as p INNER JOIN usuarios as u ON p.id = u.id_persona WHERE u.id = '$row_folio[7]'";
  $consulta_recibe = mysqli_query($conexion, $cadena_recibe);
  $row_recibe = mysqli_fetch_array($consulta_recibe);
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
    <br>FICHA DE ENTRADA</p>
    <table width='100%' border="0">
      <tr>
          <td align='left'>Suc. <?php echo $row_folio[0]; ?></td>
          <td align='right'>No. Folio: <?php echo $row_folio[1]; ?></td>
      </tr>
      <tr>
          <td colspan="2">Proveedor: <?php echo $row_folio[2]; ?></td>
      </tr>
      <tr>
          <td colspan="2">No. Factura: <?php echo $row_folio[3]; ?></td>
      </tr>
      <tr>
          <td colspan="2">Fecha: <?php echo $row_folio[4]; ?></td>
      </tr>
      <tr>
        <td colspan="2">Total: <?php echo $total; ?></td>
      </tr>
      <tr>
          <td colspan="2">Observaciones<br><?php echo $row_folio[5]; ?></td>
      </tr>
      <tr>
          <td colspan="2">Recibido por: <?php echo $row_recibe[0]; ?></td>
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