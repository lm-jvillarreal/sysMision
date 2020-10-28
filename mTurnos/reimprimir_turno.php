<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
$prefijo = date("Y") . date("m") . date("d");

?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>
<style>
  #popup {
    visibility: hidden;
    opacity: 0;
    margin-top: -350px;
  }

  #popup:target {
    visibility: visible;
    opacity: 1;
    background-color: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: 0;
    z-index: 999;
    transition: all 1s;
  }

  .popup-contenedor {
    position: relative;
    margin: 7% auto;
    padding: 30px 50px;
    background-color: #fafafa;
    color: #333;
    border-radius: 3px;
    width: 50%;
  }

  a.popup-cerrar {
    position: absolute;
    top: 3px;
    right: 3px;
    background-color: #333;
    padding: 7px 10px;
    font-size: 20px;
    text-decoration: none;
    line-height: 1;
    color: #fff;
  }

  @import url(//fonts.googleapis.com/css?family=Montserrat:400,700);

  .col-md-4 {
    text-align: center;
    font-size: 25px;
  }

  .col-md-4:last-child {
    border-right: 0px solid black;
  }

  .counter {
    font-size: 80px;
    animation-duration: 1s;
    animation-delay: 0s;
  }

  @media (max-width: 991px) {
    .col-md-4 {
      width: 50%;
      margin: auto auto;
    }
  }

  * {
    font-size: 15px;
    font-family: 'Times New Roman';
  }

  td,
  th,
  tr,
  table {
    border-top: 1px solid black;
    border-collapse: collapse;
  }

  td.turno,
  th.turno {
    width: 255px;
    max-width: 255px;
  }

  .centrado {
    text-align: center;
    align-content: center;
  }

  .ticket {
    width: 255px;
    max-width: 255px;
  }

  img {
    max-width: 150px;
    width: 150px;
  }

  @media print {
    .oculto-impresion,
    .oculto-impresion * {
      display: none !important;
    }
  }
</style>

<body>
  <div style="padding: 20px; margin: 0px;" id="ticket" class="ticket">
    <img style="padding-left: 50px;" src="../d_plantilla/dist/img/logofm.jpg" alt="Logotipo">
    <p class="centrado">FARMACIAS LA MISIÓN SUPERMERCADO S.A DE C.V.
      <br><?php echo $fecha; ?> <?php echo $hora; ?></p>
    <table>
      <thead>
        <tr>
          <th class="turno">ESPERE SU TURNO</th>
        </tr>
        <tr>
          <th><?php echo $_GET['id_turno']; ?> </th>
        </tr>
      </thead>
    </table>
    <p class="centrado"> ¡GRACIAS POR SU ESPERA!
      <br>www.lamisionsuper.com</p>
  </div>
  <button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
  <script>
    function imprimir() {
      window.print();
    }
  </script>
</body>

</html>