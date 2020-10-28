<?php 
include '../global_settings/conexion.php';

	$pFecha = $_POST['fecha'];
  $pIdMapeo = $_POST['id_mapeo'];

  if ($pFecha == "") {
    
  }
  else{
      $UP = "UPDATE mapeo SET fecha_conteo = '$pFecha' WHERE id = $pIdMapeo";
      $exUp = mysqli_query($conexion, $UP);
  }



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
              captura.cantidad,
              detalle_mapeo.descripcion
            FROM
              inv_detalle_mapeo detalle_mapeo
            
            INNER JOIN inv_mapeo mapeo ON mapeo.id = detalle_mapeo.id_mapeo
            LEFT JOIN inv_captura captura ON captura.id_detalle_mapeo = detalle_mapeo.id
            WHERE
              mapeo.id = '$pIdMapeo'
            ORDER BY
              detalle_mapeo.estante,
              detalle_mapeo.consecutivo_mueble";
              //echo "$qry";
    $exQry=mysqli_query($conexion, $qry);
    $num = mysqli_num_rows($exQry);

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
             <th>Cons</th>
             <th>Codigo del producto</th>
             <th>Descripcion</th>
             <th width="6">Cant</th>
             <th width="6">Cant 2</th>
             <th width="6">Cant 3</th>
             <th>Total</th>
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
               <td width="5%">
                <?php echo "$row[5]"; //Consecutivo  ?>
               </td>
               <td>
                 <?php echo "$row[3]"; //Codigo del producto  ?>
                 <input type="hidden" name="codigo[]" value="<?php echo $row[3] ?>">
               </td>
               <td>
                 <?php echo "$row[4]"; //descripcion ?>
               </td>
               <td width="6">
                  <input type="text"
                    <?php if (is_null($row[9])) {
                      echo "value = 0";

                    }else{
                      echo "readonly value= $row[9]";
                    
                    } ?> 
                     id="cantidad1_<?php echo "$n"; ?>" class="form-control" name="cantidad1[]" size="4" onkeyup="if(event.keyCode == 13) sumar(1,'<? echo "$n"; ?>');"
                 
               </td>
              <td width="6">
                  <input type="text"
                    <?php if (is_null($row[9])) {
                      echo "value = 0";

                    }else{
                      echo "readonly value= $row[9]";
                    
                    } ?> 
                     size="4" id="cantidad2_<?php echo "$n"; ?>" name="cantidad2[]" class="form-control" onkeyup="if(event.keyCode == 13) sumar(2,'<? echo "$n"; ?>');"
                 
               </td>
              <td width="6">
                  <input type="text"
                    <?php if (is_null($row[9])) {
                      echo "value = 0";

                    }else{
                      echo "readonly value= $row[9]";
                    
                    } ?> 
                     size="4" id="cantidad3_<?php echo "$n"; ?>" name="cantidad3[]" class="form-control" onkeyup="if(event.keyCode == 13) sumar(3,'<? echo "$n"; ?>');"
                 
               </td>
                <td align="center">
                  <input type="text" id="total_<?php echo"$n"; ?>" name="total[]" class="form-control" size="4" readonly>
               </td>
             </tr>
             <?
             $n++;
           }
           ?>
       </table>
     </form>
   </div>
   </body>
