<?php
include '../global_seguridad/verificar_sesion.php';
$no_ticket = $_GET['tckt'];
$remision = $_GET['remision'];
$prov = $_GET['proveedor'];

$cadenaUser = "SELECT
            nombre_usuario 
            FROM
            usuarios AS u
            INNER JOIN inv_remisiones AS r ON u.id = r.USUARIO
            WHERE r.ID='$no_ticket'";
$consultaUser = mysqli_query($conexion, $cadenaUser);
$rowUser = mysqli_fetch_array($consultaUser);

$cadena_voucher = "SELECT
                    CANTIDAD,
                    ARTC_ARTICULO,
                    CONCAT('$',round(COSTO_UNITARIO,2)),
                    CONCAT('$',round(COSTO_RENGLON,2)),
                    round(COSTO_RENGLON,2)
                    FROM
                    inv_renglonesremision
                    WHERE ID_REMISION='$no_ticket'";

$consulta_remision = mysqli_query($conexion, $cadena_voucher);
$existe = 0;
if ($existe) {
  echo "La Nota de Remisión con ese folio no ha sido encontrada";
} else {
  ?>
  <!DOCTYPE html>
  <html id="voucher" lang="es">

  <head>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>
    <div class="ticket">
      <p class="centrado">
        La Misión Supermercados, S.A. de C.V.
        <br>SUCURSAL <?php echo $nombre_sede; ?>
        <br>RFC: MSU940322LJ4
        <br>DIAZ ORDAZ 0-901 CENTRO 67700 LINARES 19 MEX
        <br>821 212 6200
        <br><br><strong>NOTA DE REMISIÓN</strong>
        <br>
      </p>
      <p>
        <strong>Folio: <?php echo $remision; ?></strong>
        <br>
        <strong>Proveedor: <?php echo $prov; ?></strong>
        <br>
        <strong>Bodeguero: <?php echo $rowUser[0]; ?></strong>
      </p>
      <table border="0">
        <tr>
          <th class="cantidad">Cant.</th>
          <th class="producto">Artículo</th>
          <th class="precio">C.U.</th>
          <th class="precio">C.T.</th>
        </tr>
        <?php
          $total_general = 0;
          while ($row_rem = mysqli_fetch_array($consulta_remision)) {
            ?>
          <tr>
            <td class="cantidad"><?php echo $row_rem[0] ?></td>
            <td class="producto"><?php echo $row_rem[1] ?></td>
            <td class="precio"><?php echo $row_rem[2] ?></td>
            <td class="precio"><?php echo $row_rem[3] ?></td>
          </tr>
        <?php
            $total_general = $total_general + $row_rem[4];
          }
          ?>
      </table>
      <p style="text-align: right">
        <strong>Total: <?php echo "$" . $total_general; ?></strong>
      </p>
      <br>
      <table width='100%' height='150px' border="2">
        <tr>
          <td></td>
        </tr>
      </table>
    </div>
    <br>
    <button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
    <script>
      function imprimir() {
        window.print();
      }
    </script>
  </body>

  </html>
<?php
}
?>