<?php 
include '../global_settings/conexion.php';
error_reporting(E_ALL ^ E_NOTICE);

	$fecha_inicial = $_POST['fecha_inicial'];
  $fecha_final = $_POST['fecha_final'];
  $codigo = $_POST['codigo'];

  // if ($pFecha == "") {
    
  // }
  // else{
  //     $UP = "UPDATE mapeo SET fecha_conteo = '$pFecha' WHERE id = $pIdMapeo";
  //     $exUp = mysqli_query($conexion, $UP);
  // }



		// $qry = "SELECT 
  //             m.id, 
  //             m.id_area, 
  //             m.zona, 
  //             m.mueble, 
  //             m.cara, 
  //             dm.estante, 
  //             dm.consecutivo_mueble, 
  //             dm.codigo_producto, 
  //             dm.descripcion,
  //             c.cantidad,
  //             case m.activo
  //             WHEN 1 THEN
  //             'SIN CAPTURAR'
  //           ELSE
  //             'CAPTURADO'
  //                 end 
  //           AS estatus,
  //             u.nombre_usuario,
  //             areas.nombre
  //         FROM inv_detalle_mapeo dm 
  //         INNER JOIN inv_mapeo m ON m.id= dm.id_mapeo
  //         INNER JOIN areas ON areas.id =m.id_area
  //         INNER JOIN usuarios u ON m.usuario = u.id
  //         LEFT JOIN inv_captura c ON c.id_detalle_mapeo = dm.id
  //         WHERE codigo_producto = '$pCodigo' 
  //         and m.fecha_conteo <= '$pFecha'
  //         and m.fecha_conteo >= date_sub('$pFecha', interval 15 day)
  //         GROUP BY m.id";
  $qry = "SELECT 
              m.id, 
              m.id_area, 
              m.zona, 
              m.mueble, 
              m.cara, 
              dm.estante, 
              dm.consecutivo_mueble, 
              dm.codigo_producto, 
              dm.descripcion,
              (SELECT SUM(ca.cantidad) FROM inv_mapeo mp
              INNER JOIN inv_captura ca ON ca.id_mapeo = mp.id 
              WHERE ca.cod_producto = '$codigo' 
              AND mp.id = m.id) as c,
              case m.activo
              WHEN 1 THEN
              'SIN CAPTURAR'
            ELSE
              'CAPTURADO'
                  end 
            AS estatus,
              u.nombre_usuario,
              areas.nombre,
              m.fecha_conteo,
              s.nombre,
              (SELECT u.nombre_usuario FROM inv_captura ic INNER JOIN usuarios u ON u.id = ic.usuario WHERE ic.id_mapeo = m.id LIMIT 1)
              
          FROM inv_detalle_mapeo dm 
          INNER JOIN inv_mapeo m ON m.id= dm.id_mapeo
          INNER JOIN areas ON areas.id =m.id_area
          INNER JOIN usuarios u ON m.usuario = u.id
          INNER JOIN sucursales s ON s.id = m.id_sucursal
          WHERE dm.codigo_producto = '$codigo' 
          and m.fecha_conteo BETWEEN '$fecha_inicial' AND '$fecha_final'
          GROUP BY m.id";
              //echo "$qry";
              ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $exQry=mysqli_query($conexion, $qry);
    //echo "$qry";
 ?>
 <script>
   $(document).ready(function() {
     $('#capture').dataTable({
       "language": {
         "url": "../assets/js/Spanish.json"
       },
       "dom": 'Bfrtip',
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'FaltantesComprador',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'CostosCero',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
        ],
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
            <th>Sucursal</th>
            <th>Folio</th>
             <th>Area</th>
             <th>Zona</th>
             <th>Mueble</th>
             <th>Cara</th>
             <th>Estante</th>
             <th>Consecutivo</th>
             <th>Codigo</th>
             <th width="40%">Descripcion</th>
             <th>Cantidad</th>
             <th>Estatus</th>
             <th>Mapeo</th>
             <th>Captura</th>
           </tr>
         </thead>

         <body>
           <?php
           $n=1;
           while($row = mysqli_fetch_array($exQry))
           {
           ?>
             <tr>
              <td><?php echo $row[14] ?></td>
              <td>
                <?php echo "$row[0]"; ?>
              </td>
               <td>
                 <?php echo "$row[12]"; //Nivel ?>
               </td>
               <td>
                <?php echo "$row[2]"; //Consecutivo  ?>
               </td>
               <td>
                 <?php echo "$row[3]"; //Codigo del producto  ?>
               </td>
               <td>
                 <?php echo "$row[4]"; //descripcion ?>
               </td>
               <td><?php echo $row[5] ?></td>
                <td align="center">
                  <?php echo $row[6] ?>
               </td>
               <td><?php echo $row[7] ?></td>
               <td width="40%"><?php echo $row[8] ?></td>
               <td><?php echo $row[9] ?></td>
               <td><?php echo $row[10] ?></td>
               <td><?php echo $row[11] ?></td>
               <td><?php echo $row[15] ?></td>
             </tr>
             <?
             $n++;
           }
           ?>
       </table>
     </form>
   </div>
   </body>
