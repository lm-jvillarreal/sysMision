<?php
    //include '../global_settings/conexion_pruebas.php';
		//include '../configuracion/conexion.php';
include '../global_seguridad/verificar_sesion.php';
    $pId_mapeo = $_POST['id_mapeo'];
		$qry = "SELECT
            	mapeo.zona,
            	mapeo.mueble,
            	mapeo.cara,
            	detalle_mapeo.codigo_producto,
            	detalle_mapeo.descripcion,
            	detalle_mapeo.consecutivo_mueble,
            	detalle_mapeo.estante,
							detalle_mapeo.id,
              detalle_mapeo.id_mapeo,
              mapeo.id
            FROM
            	inv_detalle_mapeo detalle_mapeo
            INNER JOIN inv_mapeo mapeo ON mapeo.id = detalle_mapeo.id_mapeo
            WHERE
            	detalle_mapeo.id_mapeo = '$pId_mapeo'
            GROUP BY detalle_mapeo.id
						ORDER BY detalle_mapeo.estante, detalle_mapeo.consecutivo_mueble";
            //echo "$qry";
    $exQry=mysqli_query($conexion, $qry);
 ?>
 <script>
   $(document).ready(function() {
     $('#example').dataTable({
       "language": {
         "url": "../assets/js/Spanish.json"
       }, 
       "lengthMenu":
          [[-1], [ "All"]]
     });
   });
 </script>
   <div class="table-responsive">
     <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
       <thead>
         <tr>
           <th>Nivel</th>
           <th>Consecutivo</th>
           <th>Codigo del producto</th>
           <th>Descripcion</th>
           <th>Editar</th>
           <th>Eliminar</th>

         </tr>
       </thead>

       <body>
         <?php
         $n = 1;
         while($row = mysqli_fetch_array($exQry))
         {

         ?>
           <tr>
             <td>
              <input type="hidden" value="<?php echo"$n"?>" id="n">
               <?php echo "$row[6]"; //Nivel ?>
             </td>
             <td>
              <?php echo "$row[5]"; //Consecutivo  ?>
              <input type="hidden" id="consecutivo_<?php echo "$n";?>" value="<?php echo "$row[5]"; ?>">
             </td>
             <td>
               <?php echo "$row[3]"; //Codigo del producto  ?>
             </td>
             <td>
               <?php echo "$row[4]"; //descripcion ?>
             </td>
             <td align="center">
               <a href="javascript:editar_renglon('<?php echo"$row[3]"; ?>', '<?php echo"$row[4]"; ?>', <?php echo $row[7] ?>);"><i class="fa fa-pencil fa-2x color-icono" aria-hidden="true"></i></a>
             </td>
             <td align="center">
               <a href="javascript:eliminar_renglon('<?php echo"$row[7]"; ?>');"><i class="fa fa-trash fa-2x color-icono" aria-hidden="true"></i></a>
             </td>
           </tr>
           <?php
           $n = $n+1;
         }
         ?>
     </table>
   </div>
   </body>
