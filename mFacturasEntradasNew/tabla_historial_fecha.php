<?php 
	include '../global_settings/conexion.php';
  $fecha_inicial = $_POST['fecha_inicial'];
  $fecha_final = $_POST['fecha_final'];
  $sucursal = $_POST['id_sucursal'];

		$qry = "SELECT
              notas_entrada.id,
              tipo_mov,
              sucursales.nombre,
              diferencia,
              factura,
              TRIM(proveedor),
              notas_entrada.fecha,
              personas.nombre,
              notas_entrada.folio_mov,
              notas_entrada.id_sucursal,
              notas_entrada.tipo_diferencia

            FROM
              notas_entrada
              INNER JOIN usuarios ON usuarios.id = notas_entrada.id_usuario
              INNER JOIN personas ON personas.id = usuarios.id_persona
              INNER JOIN sucursales ON sucursales.id = notas_entrada.id_sucursal
            WHERE
              notas_entrada.fecha >= '$fecha_inicial'
            AND notas_entrada.fecha <='$fecha_final'
            AND notas_entrada.id_sucursal = '$sucursal'";
             //echo "$qry";
      $exQry = mysqli_query($conexion, $qry);
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
 <script type="text/javascript">
   function ver(folio, tipo_mov, sucursal) {
  window.open("nota_cargo.php?folio="+folio+"&tipo_mov="+tipo_mov+"&sucursal="+sucursal);
}
 </script>

    <div class="table-responsive">
     <table id="capture" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Sucursal</th>
            <th>Folio</th>
            <th>Tipo de mov</th>
            <th>Proveedor</th>
            <th>Fecha</th>
            <th>Diferencia</th>
            <th>Usuario</th>
            <th>Ver</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <body>
       <?php
          $n = 1;
          while($row = mysqli_fetch_row($exQry))
          {
            // $sel_dif = "SELECT id_nota, codigo_producto, cantidad, diferencia, total FROM detalle_nota WHERE id_nota = '2' AND codigo_producto = '$row[0]'";
            // $exSdif = mysqli_query($conexion, $sel_dif);
            // $row_d = mysqli_fetch_row($exSdif);
          ?>
            <tr>
              <td align="center">
                <?php echo $row[0] ?>
              </td>
              <td>
                <?php echo "$row[2]"; ?>
              </td>
              <td align="center">
                <?php echo "$row[8]"; ?>
              </td>
              <td align="center">
                <?php echo "$row[1]"; ?>
              </td>
              <td align="center" width="10%">
                <?php echo $row[5] ?>
              </td>
              <td width="10%">
                <?php echo $row[6] ?>
              </td>
              <td><?php echo $row[3] ?></td>
              <td><?php echo $row[7] ?></td>
              <td><a href="#" class="btn btn-danger" onclick="javascript:ver('<?php echo $row[8] ?>', '<?php echo $row[1] ?>', '<?php echo $row[9] ?>')">Ver</a></td>
              <td><a href="#" class="btn btn-danger" onclick="javascript:editar_dato(<?php echo $row[10] ?>, '<?php echo $row[5] ?>', '<?php echo $row[2] ?>', '<?php echo $row[1] ?>', '<?php echo $row[8] ?>', <?php echo $row[3] ?>, <?php echo $row[0] ?>)"><i class='fa fa-edit fa-lg'></i></a></td>
              <td><a href="javascript:eliminar_dato(<?php echo $row[0] ?>)" class="btn btn-danger"><i class='fa fa-trash fa-lg'></i></a></td>
            </tr>
            <?php
          $n++;
        }
          ?>
        </body>
      </table>
   </div>