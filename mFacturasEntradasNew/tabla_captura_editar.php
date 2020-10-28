<?php 
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	  //$id = $_POST['id'];

		$qry = "SELECT clave_impuesto, codigo_producto, descripcion, cantidad, diferencia, total, id  FROM detalle_nota WHERE id_nota = '$id'";
    //echo "$qry";
    $exQry = mysqli_query($conexion, $qry);
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
            <th>Editar</th>
          </tr>
        </thead>
        <tbody id="body_tabla">
       <?php
          $n = 1;
          while($row = mysqli_fetch_row($exQry))
          {
          ?>
            <tr>
              <td>
                <select id="cmbImpuesto_<? echo $n ?>">
                  <option  selected value="0">Seleccione...</option>
                  <option value="1.06">IEPS 6</option>
                  <option value="1.08">IEPS 8</option>
                  <option value="1.16">IVA</option>
                </select>
              </td>
              <td align="center">
                <input type="text" size="10" value="<?php echo $row[1] ?>" class="form-control" name="articulo[]" readonly>
              </td>
              <td align="center">
                <input type="text" size="40" class="form-control" value="<?php echo $row[2] ?>" name="descripcion[]" readonly >
              </td>
              <td align="center" id="<?php echo $n ?>">
                <input type="text" size="3" value="<?php echo $row[3] ?>" class="form-control" name="cantidad[]" id="cantidad_<? echo $n ?>" readonly>
              </td>
              <td align="center" width="10%">
                <input type="text" size="5" onblur="calcular($(this).val(), $('#cantidad_<? echo $n ?>').val(), <?php echo $n ?>)" name="diferencia[]" id="diferencia_<? echo $n ?>" value="<?php echo $row[4] ?>" class="form-control" >
                <input type="hidden" id="totali_<? echo $n ?>" name="total[]">
                <input type="hidden" id="total_bruto_<? echo $n ?>" name="total_bruto[]">
                <input type="hidden" id="clave_<? echo $n ?>" name="clave[]">
              </td>
              <td width="10%" id="total_<?php echo $n ?>"><?php echo "$row[5]"; ?>
              </td>
              <td><a href="#" onclick="javascript:editar_renglon(<?php echo $row[6] ?>, $('#cmbImpuesto_<? echo $n ?>').val(),  $('#diferencia_<? echo $n ?>').val(), $('#total_<?php echo $n ?>').text())">Editar</a></td>
            </tr>
            <?php
          $n++;
        }
          ?>
        </tbody>
        
      </table>
   </div>