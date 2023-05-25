<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_GET['id'];
$sucursal = $id_sede;
$cadenaVale = "SELECT ID, 
                    FOLIO_TICKET, 
                    SUCURSAL, 
                    TOTAL_TICKET, 
                    CAJERO_TICKET, 
                    ARTC_ARTICULO, 
                    ARTC_DESCRIPCION, 
                    ARTC_CANTIDAD, 
                    ARTC_PRECIO, 
                    ARTC_CAMBIOPRECIO, 
                    ARTC_DIFERENCIAPRECIO, 
                    TOTAL_DIFERENCIAPRECIO, 
                    (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas INNER JOIN usuarios ON personas.id=usuarios.id_persona WHERE usuarios.id=v.ID_AUTORIZA) as Autoriza, 
                    NOMBRE_CLIENTE, 
                    FECHAHORA_CAMBIO, 
                    COMENTARIO 
              FROM valecaja_provisional as v
              WHERE ID='$id'";
$consultaVale = mysqli_query($conexion, $cadenaVale);
$row = mysqli_fetch_array($consultaVale);
$existe = count($row[0]);


if ($existe == 0) {
  echo "El folio no existe";
} else {

  switch ($row[2]) {
    case '1':
      $sucursal = "DIAZ ORDAZ";
      break;
    case '2':
      $sucursal = "ARBOLEDAS";
      break;
    case '3':
      $sucursal = "VILLEGAS";
      break;
    case '4':
      $sucursal = "ALLENDE";
      break;
    case '5':
      $sucursal = "LA PETACA";
      break;
    case '6':
      $sucursal = "MONTEMORELOS";
      break;
    default:
      $sucursal = "";
      break;
  }
  $artc_precio = "Precio Público: " . money_format("%.2n", $row[8]);
  $artc_cambio = "Cambio de Precio: " . money_format("%.2n", $row[9]);
  $artc_diferencia = "Diferencia: " . money_format("%.2n", $row[10]);
  $artc_totaldiferencia = "Total Diferencia: " . money_format("%.2n", $row[11]);
  ?>
    <!DOCTYPE html>
    <html id="vale" lang="es">

    <head>
      <link rel="stylesheet" href="style.css">
    </head>

    <body>
      <div class="ticket">
        <p class="centrado">La Misión Supermercados, S.A. de C.V.
          <br>SUCURSAL <?php echo $sucursal; ?>
          <br>RFC: MSU940322LJ4
          <br>DIAZ ORDAZ 0-901 CENTRO 67700 LINARES 19 MEX
          <br>821 212 6200
          <br>
          <br><strong>Vale Provisional de Caja</strong>
        </p>
        <table>
          <tbody>
            <tr>
              <td>Ticket: <?php echo $row[1]; ?></td>
            </tr>
            <tr>
              <td>Cajero(a): <?php echo $row[4]; ?></td>
            </tr>
            <tr>
              <td>Artículo: <?php echo $row[5]; ?></td>
            </tr>
            <tr>
              <td>Descripción: <?php echo $row[6]; ?></td>
            </tr>
            <tr>
              <td>Cantidad: <?php echo $row[7]; ?></td>
            </tr>
            <tr>
              <td><?php echo $artc_precio; ?></td>
            </tr>
            <tr>
              <td><?php echo $artc_cambio; ?></td>
            </tr>
            <tr>
              <td><?php echo $artc_diferencia; ?></td>
            </tr>
            <tr>
              <td><strong><?php echo $artc_totaldiferencia; ?></strong></td>
            </tr>
            <tr>
              <td>Observaciones:</td>
            </tr>
            <tr>
              <td><?php echo $row[15]; ?></td>
            </tr>
            <tr>
              <td><br><br></td>
            </tr>
            <tr>
              <td><center><?php echo $row[12]; ?></center></td>
            </tr>
            <tr>
              <td align="center">---------------------------------------------------------<br>
                <center>
                  Autoriza
                </center>
              </td>
            </tr>
            <tr>
              <td><br><br></td>
            </tr>
            <tr>
              <td><center><?php echo $row[13]; ?></center></td>
            </tr>
            <tr>
              <td align="center">---------------------------------------------------------<br>
                <center>
                  Cliente
                </center>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <br><br>
      <center><button class="oculto-impresion" onclick="imprimir()">Imprimir</button></center>
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