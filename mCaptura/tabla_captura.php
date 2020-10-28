<?php 
include '../global_settings/conexion.php';
error_reporting(E_ALL ^ E_NOTICE);

	$pFecha = $_POST['fecha'];
  $pIdMapeo = $_POST['id_mapeo'];

  // if ($pFecha == "") {
    
  // }
  // else{
  //     $UP = "UPDATE mapeo SET fecha_conteo = '$pFecha' WHERE id = $pIdMapeo";
  //     $exUp = mysqli_query($conexion, $UP);
  // }



		$qry = "SELECT
              inv_mapeo.zona,
              inv_mapeo.mueble,
              inv_mapeo.cara,
              inv_detalle_mapeo.codigo_producto,
              inv_detalle_mapeo.descripcion,
              inv_detalle_mapeo.consecutivo_mueble,
              inv_detalle_mapeo.estante,
              inv_detalle_mapeo.id,
              inv_detalle_mapeo.id_mapeo,
              captura.cantidad AS cantidad
            FROM
              inv_detalle_mapeo
            INNER JOIN inv_mapeo ON inv_mapeo.id = inv_detalle_mapeo.id_mapeo
            LEFT JOIN inv_captura captura ON captura.id_detalle_mapeo = inv_detalle_mapeo.id
            WHERE
              inv_mapeo.id = '$pIdMapeo'
              GROUP BY inv_detalle_mapeo.id
            ORDER BY
              inv_detalle_mapeo.estante,
              inv_detalle_mapeo.consecutivo_mueble";
              //echo "$qry";
              ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $exQry=mysqli_query($conexion, $qry);
    $num = mysqli_num_rows($exQry);
    //echo "$qry";
 ?>
 <script>
   $(document).ready(function() {
     $('#capture').dataTable({
       "language": {
         "url": "../assets/js/Spanish.json"
       },
       "lengthMenu":
          [[-1], [ "All"]]
     });
   });
 </script>
   <div class="table-responsive">
    <form id="frmTabla">
       <table id="capture" class="table table-striped table-bordered" cellspacing="0" width="100%">
         <thead>
           <tr>
            <th>#</th>
             <th>Nivel</th>
             <th>Consecutivo</th>
             <th>Codigo del producto</th>
             <th>Descripcion</th>
             <th>Cantidad</th>
             <th>Modificar</th>
           </tr>
         </thead>

         <body>
           <?php
           $n=1;
           while($row = mysqli_fetch_array($exQry))
           {
           ?>
             <tr>
              <td>
                <?php echo "$n"; ?>
                <input type="hidden" name="registros[]" value="<?php echo $n ?>">
                <input type="hidden" name="id_mapeo[]" value="<?php echo $row[8] ?>">
                <input type="hidden" name="id_detalle[]" value="<?php echo $row[7] ?>">
              </td>
               <td>
                 <?php echo "$row[6]"; //Nivel ?>
               </td>
               <td>
                <?php echo "$row[5]"; //Consecutivo  ?>
               </td>
               <td>
                 <?php echo "$row[3]"; //Codigo del producto  ?>
                 <input type="hidden" name="codigo[]" value="<?php echo $row[3] ?>">
               </td>
               <td>
                 <?php echo "$row[4]"; //descripcion ?>
               </td>
               <td>
                  <input type="text"
                    <?php if (is_null($row[9]) || $row[9] == "0") {
                      echo "value = 0";

                    }else{
                      echo "readonly value= $row[9]";
                    
                    } ?> 
                    name="cantidad[]" id="cantidad_<?php echo "$n"; ?>" class="form-control" onkeyup="if(event.keyCode == 13) capturar('<?php echo "$row[8]";?>','<?php echo "$row[7]"?>', '<?php echo "$row[3]"?>', $(this).val(), '<?php echo "$n"; ?>'); if (event.keyCode == 9) tabulacion(<?php echo $n ?>);">
                 
               </td>
                <td align="center">
                  <a onclick="javascript:editar('<?php echo"$row[7]" ?>', '<?php echo"$row[3]" ?>', '<?php echo"$row[4]" ?>', <?php echo"$n"; ?>);">Editar</a>
               </td>
             </tr>
             <?php
             $n++;
           }
           ?>
       </table>
     </form>
   </div>
   </body>
