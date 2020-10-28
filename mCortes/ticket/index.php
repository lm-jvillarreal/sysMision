<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>

</head>

<body>
        <?php 
        include '../../configuracion/conexion_servidor.php';
        $id_turno = $_GET['id'];
        $sucursal = $_GET['sucursal'];
        $prov = $_GET['proveedor'];
        $tipo = $_GET['tipo'];
        if ($tipo == 1) {
          $t = "Local";
        }else{
          $t = "Foraneo";
        }
        if ($sucursal == 11) {
          $suc = "Diaz Ordaz";
        }elseif($sucursal == 2){
          $suc = "Arboledas";
        }elseif($sucursal == 3){
          $suc = "Villegas";
        }elseif($sucursal == 4){
          $suc = "Allende";
        }
        $qry ="SELECT
                  turnos.turno,
                  turnos.hora, turnos.fecha
                FROM
                  turnos
                WHERE
                  turnos.id = '$id_turno'";
        $exQry = mysqli_query($conexion_mysql, $qry);
       ?>
  <?php 
    date_default_timezone_set('America/Monterrey');
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
   ?>
  <div id="ticket" class="ticket">
    <img src="logo.png" alt="Logotipo">
    <p class="centrado">TURNOS PARA RECIBO
      <br>Suc <?php echo $suc ?>
      <br>Fecha: <?php echo $fecha ?></p>
      <br>Nombre: <?php echo $prov ?>


     <hr>

    <table class="centrado" align="center">
      <thead>
        <tr>
          <?php $row = mysqli_fetch_row($exQry) ?>
          <th class="cantidad">Turno: <?php echo $row[0] ?></th>
        </tr>
      </thead>
      <tbody>
        <td>Tipo: <?php echo $t ?></td>
      </tbody>
    </table>
    <hr>
    Para mas Informacion: 821-212-6200 Ext. 112
    <br>
    <hr>
    Importante: EN CASO DE QUE NO ESTE PRESENTE AL MOMENTO DE SU TURNO ESTE SE BRINCARÁ.
    <hr>
    Quejas y sugerencias:
    heraclio_mz@lamisionsuper.com
  </div>
  <!-- <button class="oculto-impresion" onclick="imprimir()">Imprimir</button> -->
  <input type="button" onclick="printDiv('ticket')" value="imprimir div" />
</body>
</html>