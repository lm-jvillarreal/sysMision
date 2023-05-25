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
            AND MODC_TIPOMOV = '$movimiento'
            ";
             //echo "$qry";
      $st = oci_parse($conexion_central, $qry);
      oci_execute($st);
 ?>
  <script>
   $(document).ready(function() {
     $('#capture').dataTable({
       "language": {
         "url": "../plugins/DataTables/Spanish.json"
       },
       'paging'    : false,
     });
   });
 </script>

    <div class="table-responsive">
     <table id="capture" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Impuesto</th>
            <th>Articulo</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Dif</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody id="body_tabla">
       <?php
          $n = 1;
          while($row = oci_fetch_row($st))
          {
          ?>
            <tr>
              <td>
                <select id="cmbImpuesto_<?php echo $n ?>">
                  <option  selected value="0">Seleccione...</option>
                  <option value="1.06">IEPS 6</option>
                  <option value="1.08">IEPS 8</option>
                  <option value="1.16">IVA</option>
                </select>
              </td>
              <td align="center">
                <input type="text" size="10" value="<?php echo $row[0] ?>" class="form-control" name="articulo[]" readonly>
              </td>
              <td align="center"><?php echo $row[1] ?>
                <div style="display: none;"><input type="text" size="40" class="form-control" value="<?php echo $row[1] ?>" name="descripcion[]" readonly ></div>
              </td>
              <td align="center" id="<?php echo $n ?>">
                <input type="text" size="3" value="<?php echo $row[2] ?>" class="form-control" name="cantidad[]" id="cantidad_<?php echo $n ?>" readonly>
              </td>
              <td align="center" width="10%">
                <input type="text" size="5" onblur="calcular($(this).val(), $('#cantidad_<?php echo $n ?>').val(), <?php echo $n ?>)" name="diferencia[]" class="form-control">
                <input type="hidden" id="totali_<?php echo $n ?>" name="total[]">
                <input type="hidden" id="total_bruto_<?php echo $n ?>" name="total_bruto[]">
                <input type="hidden" id="clave_<?php echo $n ?>" name="clave[]">
              </td>
              <td width="10%" id="total_<?php echo $n ?>">0

              </td>
            </tr>
            <?php
          $n++;
        }
          ?>
        </tbody>
        
      </table>
   </div>