<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
</head>

<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<?php include '../header.php'; ?>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<?php include 'menuV.php'; ?>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Explosión de materiales | Explosión</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
                                            <th width='10%'>Artículo</th>
                                            <th>Descripción</th>
                                            <th width='5%'>Lunes</th>
                                            <th width='5%'>Martes</th>
                                            <th width='5%'>Miércoles</th>
                                            <th width='5%'>Jueves</th>
                                            <th width='5%'>Viernes</th>
                                            <th width='5%'>Sábado</th>
                                            <th width='5%'>Domingo</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>

		<!-- /.content-wrapper -->
        <?php include 'modal_detalle_exp.php'; ?>
		<?php include '../footer2.php'; ?>

		<!-- Control Sidebar -->

		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
	   immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->

	<?php include '../footer.php'; ?>
	<!-- Page script -->
	<script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script>
        $(document).ready(function(e) {
            cargar_tabla();
        });

        function cargar_tabla() {
            $('#lista_articulos').dataTable().fnDestroy();
            $('#lista_articulos').DataTable({
                'language': {
                    "url": "../plugins/DataTables/Spanish.json"
                },
                "paging": false,
                "dom": 'Bfrtip',
                buttons: [
                    {
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
                    {
                        extend: 'excel',
                        text: 'Exportar a Excel',
                        className: 'btn btn-default',
                        title: 'FaltantesLista',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Exportar a PDF',
                        className: 'btn btn-default',
                        title: 'FaltantesLista',
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
                    // {
                    //     text: 'Actualizar costos',
                    //     className: 'red',
                    //     action: function() {
                    //         actualizar_costos();
                    //     },
                    //     counter: 1
                    // },
                ],
                "ajax": {
                    "type": "POST",
                    "url": "tabla_explosion_materiales.php",
                    "dataSrc": "",
                    "data": ""
				},
                "columns": [/*{
                        "data": "id"
                    },*/
                    {
                        "data":"artc_articulo",
                        "width": "10%"
                    },{
                        "data":"artc_descripcion",
                    },{
                        "data": "lunes",
                        "width": "5%"
                    },
                    {
                        "data": "martes",
                        "width": "5%"
                    },
                    {
                        "data": "miercoles",
                        "width": "5%"
                    },
                    {
                        "data": "jueves",
                        "width": "5%"
                    },
                    {
                        "data": "viernes",
                        "width": "5%"
                    },
                    {
                        "data": "sabado",
                        "width": "5%"
                    },
                    {
                        "data": "domingo",
                        "width": "5%"
                    }
                ]
            });
        }

        $('#modal-detalle').on('show.bs.modal', function(e) {
            $(".modal-dialog").css("width", "95%");
            var folio = $(e.relatedTarget).data().folio;
            var tipo = $(e.relatedTarget).data().tipo;
            var idprod = $(e.relatedTarget).data().idprod;
            //alert(id);
            var url = "detalle_modal_prod.php"; // El script a dónde se realizará la petición.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                folio: folio,
                tipo: tipo,
                idprod: idprod
                }, // Adjuntar los campos del formulario enviado.
                success: function(respuesta) {
                    var array = eval(respuesta);
                    $("#id_receta").val(array[2]);
                    $("#clave_receta").val(array[0]);
                    $("#tipo").val(array[1]);
                    //console.log(array[0] + "_" + array[1] + "_" + array[2] + "_" + array[3] + "_" +  array[4]+ "_" +  array[5]+"_"+ array[6]+"_"+ array[7]+"_"+ array[8]);
                    cargar_tabla_modal(array[2], array[0], array[3], array[4], array[5], array[6], array[7], array[8]);
                }
            });
        });

        function cargar_tabla_modal(id_receta, folio, lunes, martes, miercoles, jueves, viernes, sabado) {
            $('#lista_detalle').dataTable().fnDestroy();
            $('#lista_detalle').DataTable({
                initComplete: function() {
                this.api().columns.adjust();
                var costo_bruto=$("#cedula_costobruto").val();
                var merma_s = (costo_bruto*0.03).toFixed(2);
                var costo_neto = (parseFloat(costo_bruto)+parseFloat(merma_s)).toFixed(2);
                $("#cedula_merma").val(merma_s);
                $("#cedula_costoneto").val(costo_neto);
                },
                'language': {
                "url": "../plugins/DataTables/Spanish.json"
                },
                "paging": false,
                "dom": 'Bfrtip',
                buttons: [
                {
                    extend: 'pageLength',
                    text: 'Registros',
                    className: 'btn btn-default'
                },
                {
                    extend: 'excel',
                    text: 'Exportar a Excel',
                    className: 'btn btn-default',
                    title: 'FaltantesLista',
                    exportOptions: {
                    columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Exportar a PDF',
                    className: 'btn btn-default',
                    title: 'FaltantesLista',
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
                }
                ],
                "ajax": {
                "type": "POST",
                "url": "tabla_detalle_exp.php",
                "dataSrc": "",
                "data": {
                    id_receta: id_receta,
                    lunes:lunes,
                    martes:martes,
                    miercoles:miercoles,
                    jueves:jueves,
                    viernes:viernes,
                    sabado:sabado
                }
                },
                "columns": [{
                    "data":"artc_articulo",
                    "width": "5%"
                },{
                    "data":"artc_descripcion",
                    "width":"5%"
                },{
                    "data": "lunes",
                    "width": "5%"
                },
                {
                    "data": "martes"
                },
                {
                    "data": "miercoles"
                },
                {
                    "data": "jueves",
                    "width": "6%"
                },
                {
                    "data": "viernes",
                    "width": "5%"
                },
                {
                    "data": "sabado",
                    "width": "5%"
                }
                ],
                "rowCallback": function(row, data, index) {
                $("#cedula_costobruto").val((parseFloat($("#cedula_costobruto").val()) + parseFloat(data.precio_unitario)).toFixed(2));
                }
            });
        }
	</script>
</body>
</html>