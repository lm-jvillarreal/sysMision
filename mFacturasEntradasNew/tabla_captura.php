<?php 
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	  $folio = $_POST['folio'];
    $movimiento = $_POST['movimiento'];
    $almacen = $_POST['sucursal'];

		$qry = "SELECT
              ARTC_ARTICULO,
              ARTC_DESCRIPCION,
              RMON_CANTSURTIDA
            FROM
              INV_RENGLONES_MOV_DESC_VW
            WHERE
              MODN_FOLIO = '$folio'
            AND ALMN_ALMACEN = '$almacen'
            AND MODC_TIPOMOV = '$movimiento'";
             echo "$qry";
      $st = oci_parse($conexion_central, $qry);
      oci_execute($st);
 ?>
  <script>
   $(document).ready(function() {
     $('#capture').dataTable({
       "language": {
         "url": "../assets/js/Spanish.json"
       }
     });
   });
 </script>

    <div class="table-responsive">
     <table id="capture" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>A</th>
            <th>Articulo</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Dif</th>
            <th>Total</th>
          </tr>
        </thead>
        <body>
       <?php
          $n = 1;
          while($row = oci_fetch_row($st))
          {
            // $sel_dif = "SELECT id_nota, codigo_producto, cantidad, diferencia, total FROM detalle_nota WHERE id_nota = '2' AND codigo_producto = '$row[0]'";
            // $exSdif = mysqli_query($conexion, $sel_dif);
            // $row_d = mysqli_fetch_row($exSdif);
          ?>
            <tr>
              <td align="center">
                <input type="checkbox">
              </td>
              <td>
                <?php echo "$row[0]"; ?>
              </td>
              <td align="center">
                <?php echo "$row[1]"; ?>
              </td>
              <td align="center">
                <?php echo "$row[2]"; ?>
                <input type="hidden" id="cantidad_<?php echo $n;?>" value="<?php echo $row[2] ?>">
              </td>
              <td align="center" width="10%">
                <input value="<?php echo $row_d[3] ?>" type="text" onblur="calcular($('#cantidad_<?php echo $n;?>').val(), $(this).val(), <?php echo $n ?>, '<?php echo $row[0] ?>', <?php echo $id_nota ?>, '<?php echo $row[1] ?>')" class="form-control">
              </td>
              <td width="10%">
                <input readonly value= "<?php echo $row_d[4] ?>" type="text" id="total_<?php echo $n ?>" class="form-control">
              </td>
            </tr>
            <?php
          $n++;
        }
          ?>
        </body>
      </table>
   </div>