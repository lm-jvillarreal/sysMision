<script>
  function estilo_tablas () {
    $('#lista_requisicion').DataTable({
      'paging'    : true,
      'lengthChange'  : true,
      'searching'   : true,
      'ordering'    : true,
      'info'      : true,
      'autoWidth'   : false,
      'language'    : {"url": "../plugins/DataTables/Spanish.json"}
    })
   }  
  $(function (){
   estilo_tablas();
  })
</script>
<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_tabla = "SELECT
                    m.id,
                    m.folio,
                    m.id_sucursal,
                    s.nombre,
                    m.id_usuario,
                    CONCAT(
                        p.nombre,
                        ' ',
                        p.ap_paterno,
                        ' ',
                        p.ap_materno
                    ) AS persona,
                    m.fecha
                FROM
                    materiales m
                INNER JOIN historial_pedido_materiales h ON h.folio = m.folio
                INNER JOIN sucursales s ON s.id = m.id_sucursal
                INNER JOIN usuarios u ON u.id = h.id_usuario
                INNER JOIN personas p ON p.id = u.id_persona
                WHERE
                    m.activo = '2'
                GROUP BY
                    m.folio";
$consulta_tabla = mysqli_query($conexion, $cadena_tabla);
?>
	<div class="table-responsive">
        <table id="lista_requisicion" class="table table-striped table-bordered" cellspacing="0" width="100%">
	        <thead>
	            <tr>
                    <th width="2%">#</th>
                    <th>Fecha</th>
                    <th>Folio</th>
                    <th>Sucursal</th>
                    <th>Usuario</th>
                    <th>Pedido</th>
                    <th>Liberar</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php 
                $n=1;
	        	while($row = mysqli_fetch_row($consulta_tabla))
				{	
					?>
					<tr>
                        <td>
						    <center>
				                <?php echo $n; ?>
                            </center>
						</td>
                        <td>
						    <center>
				                <?php echo date("d-m-Y",strtotime($row[6]));?>
                            </center>
						</td>
                        <td>
						    <center>
				                <?php echo $row[1]; ?>
                            </center>
						</td>
                        <td>
						    <center>
				                <?php echo $row[3]; ?>
                            </center>
						</td>
                        <td>
						    <center>
                                <?php echo $row[5]; ?>
                            </center>
						</td>
                        <td>
						    <center>
				                <a href="javascript:GenerarPdf('<? echo"$row[1]"; ?>');" class='fa fa-file-pdf-o fa-3x' style="color: #DF0101;"></a>
                            </center>
						</td>
						<td>
						    <center>
				                <a href="javascript:Generarliberacion('<? echo"$row[1]"; ?>');" class='fa fa-check fa-3x' style="color: #DF0101;"></a>
                            </center>
						</td>
					</tr>
				<?php 
                $n++;
				}
				 ?>
	        </tbody>  
		</table>
	</div>