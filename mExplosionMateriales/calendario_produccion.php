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
						<h3 class="box-title">Explosión de materiales | Calendario de producción</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
                                                <th width='15%'>Articulo</th>
                                                <th width='15%'>Tipo</th>
                                                <th width='15%'>Producto</th>
												<th width='15%'>Producción semanal</th>
												<th width='10%'>Lunes</th>
												<th width='10%'>Martes</th>
                                                <th width='5%'>Miércoles</th>
                                                <th width='5%'>Jueves</th>
                                                <th width='5%'>Viernes</th>
                                                <th width='5%'>Sábado</th>
                                                <th width='5%'>Domingo</th>
                                                <th width='5%'>Faltante</th>
                                                <th width='5%'>Opciones</th>
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
        <?php include 'modal_detalle_prod.php'; ?>
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
                buttons: [{
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
                    "url": "tabla_cal_pro.php",
                    "dataSrc": "",
                    "data": ""
                },
                "columns": [{
                        "data":"artc_articulo"
                    },
                    {
                        "data":"tipo"
                    },
                    {
                        "data":"artc_descripcion"
                    },
                    {
                        "data":"prod_semanal"
                    },
                    {
                        "data":"prod_lunes"
                    },
                    {
                        "data":"prod_martes"
                    },
                    {
                        "data":"prod_miercoles"
                    },
                    {
                        "data":"prod_jueves"
                    },
                    {
                        "data":"prod_viernes"
                    },
                    {
                        "data":"prod_sabado"
                    },
                    {
                        "data":"prod_domingo"
                    },
                    {
                        "data":"faltante"
                    },
                    {
                        "data":"opciones"
                    },
                ]
            });
        }

        $('#btn-alta').click(function() {
            if ($("#prod_lunes").val() == "" || $("#prod_martes").val() == "" || $("#prod_miercoles").val() == "" || $("#prod_jueves").val() == "" || $("#prod_viernes").val() == "" || $("#prod_sabado").val() == ""|| $("#prod_domingo").val() == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_cal_pro.php";
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:$("#form-modal").serialize(),
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Producción añadida correctamente");
                        }else{
                            alertify.error("Se produjo un error");
                        }
                        //cargar_tabla();
                        $('#lista_articulos').DataTable().ajax.reload();
                    },
                    error: function(xhr, status){
                        alert("Error");
                    }
                })
            }
        });

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
                    $("#prod_lunes").val(array[3]);
                    $("#prod_martes").val(array[4]);
                    $("#prod_miercoles").val(array[5]);
                    $("#prod_jueves").val(array[6]);
                    $("#prod_viernes").val(array[7]);
                    $("#prod_sabado").val(array[8]);
                    $("#prod_domingo").val(array[9]);
                    $("#semana").text(array[10]);
                    $("#produccion").text($(e.relatedTarget).data().ventas);
                }
            });
        });
	</script>
</body>
</html>