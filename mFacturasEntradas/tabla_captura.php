<?php 
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	  $id_nota =$_POST['id'];

    $select = "SELECT
                id,
                folio_mov,
                tipo_mov,
                id_sucursal
              FROM
                notas_entrada
              WHERE
                id = '$id_nota'";
                // echo "$select";
    $exSelect = mysqli_query($conexion, $select);
    $row = mysqli_fetch_row($exSelect);

		$qry = "SELECT
              ARTC_ARTICULO,
              ARTC_DESCRIPCION,
              RMON_CANTSURTIDA
            FROM
              INV_RENGLONES_MOV_DESC_VW
            WHERE
              MODN_FOLIO = '$row[1]'
            AND ALMN_ALMACEN = '$row[3]'
            AND MODC_TIPOMOV = '$row[2]'";
             //echo "$qry";
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
            $sel_dif = "SELECT id_nota, codigo_producto, cantidad, diferencia, total FROM detalle_nota WHERE id_nota = '$id_nota' AND codigo_producto = '$row[0]'";
            $exSdif = mysqli_query($conexion, $sel_dif);
            $row_d = mysqli_fetch_row($exSdif);
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