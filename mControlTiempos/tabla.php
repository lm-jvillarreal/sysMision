<html>
	<?php error_reporting(E_ALL ^ E_NOTICE) ?>
    <script src="../d_plantilla/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../d_plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../d_plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../d_plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
</html>
<?php 
include '../global_settings/conexion.php';





		$qry = "SELECT
              m_e.id,
              m_e.fecha,
              m_e.hora_inicio,
              m_e.hora_fin,
              m_e.diferencia,
              m_e.comentarios,
              usuarios.nombre_usuario,
              CASE
                tipo 
                WHEN '1' THEN
                'Extra' 
                WHEN '2' THEN
                'Permiso' 
                ELSE 'Otra'
              END AS tipo
            FROM
              me_control_tiempos m_e
              INNER JOIN usuarios ON usuarios.id = m_e.usuario";
              ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $exQry=mysqli_query($conexion, $qry);

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
            <th>Usuario</th>
             <th>Fecha</th>
             <th>Hora Inicio</th>
             <th>Hora Fin</th>
             <th>Diferencia</th>
             <th>Tipo</th>
             <th>Comentarios</th>
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
              </td>
               <td>
                 <?php echo "$row[6]"; //Nivel ?>
               </td>
               <td>
                <?php echo "$row[1]"; //Consecutivo  ?>
               </td>
               <td>
                 <?php echo $row[2]; //Codigo del producto  ?>
               </td>
               <td>
                 <?php echo $row[3]; //descripcion ?>
               </td>
               <td>
                 <?php echo $row[4] ?>
               </td>
               <td>
                 <?php echo $row[7] ?>
               </td>
               <td>
                 <?php echo $row[5] ?>
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
