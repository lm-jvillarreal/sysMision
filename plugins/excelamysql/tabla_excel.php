<?php
	include '../configuracion/conexion.php';
	$qry = "SELECT MAX(mapeo.id) FROM mapeo";
	$exQry = mysqli_query($conexion, $qry);
	$r = mysqli_fetch_row($exQry);
	$select = "SELECT
                c_e.codigo_producto,
                p.descripcion,
                c_e.id,
                c_e.estante,
                c_e.consecutivo_mueble
              FROM
                detalle_mapeo AS c_e
              LEFT JOIN productos AS p ON p.codigo_producto = c_e.codigo_producto
              INNER JOIN mapeo AS m ON m.id = c_e.id_mapeo
              WHERE
                m.id = '$r[0]'
              GROUP BY c_e.id";
	$exS = mysqli_query($conexion, $select); 
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
     <table id="capture" class="table table-bordered" cellspacing="0" width="100%">
       <thead>
         <tr align="center">
            <th>Estante</th>
            <th>Consecutivo</th>
            <th>Codigo del producto</th>
            <th>Descripcion</th>
         </tr>
       </thead>

       <body>
         <?php
         $n=1;
         while($row = mysqli_fetch_array($exS))
         {
         ?>
           <tr align="center">
            <td>
              <?php echo "$row[3]"; ?>
            </td>
             <td>
               <?php echo "$row[4]"; //Nivel ?>
             </td>

             <td>
               <?php echo "$row[0]"; //Codigo del producto  ?>
             </td>
              <?php 
                if (is_null($row[1])) {
                  echo "<td bgcolor = 'red'>";
                }
                else{
                  echo "<td>";
                }
              ?>
              <?php echo "$row[1]"; //Descripcion  ?>
             </td>
           </tr>
           <?
           $n++;
         }
         ?>
     </table>
   </div>
   </body>