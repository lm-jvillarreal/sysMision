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
						<h3 class="box-title">Costo de materias primas | Lista de Registros Existentes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
                                                <th width='5%'>Artículo</th>
                                                <th width='10%'>Tipo de Producto</th>
												<th>Producto</th>
                                                <th width='10%'>U.M.</th>
												<th width='10%'>C.U.</th>
												<th width='15%'>Cantidad</th>
                                                <!--th>Acciones</th-->
												<th width='15%'>Valor Total</th>
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
		<?php include '../footer2.php'; ?>

		<!-- Control Sidebar -->

		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
	   immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->
    <?php include 'modal_cantidad.php'; ?>
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
                    "url": "tabla_inventario_pos.php",
                    "dataSrc": "",
                    "data": ""
                },
                "columns": [{
                        "data": "artc_articulo"
                    },
                    {
                        "data": "tipo"
                    },
                    {
                        "data": "artc_descripcion"
                    },
                    {
                        "data": "unimedida_venta"
                    },
                    {
                        "data": "rmon_ultimoprecio",
                        "render": $.fn.dataTable.render.number( ',', '.', 2, '$' )
                    },
                    {
                        "data": "cantidad"
                    },
                    /*{
                        "data":"acciones"
                    },*/
                    {
                        "data": "total",
                        "render": $.fn.dataTable.render.number( ',', '.', 2, '$' )
                    }
                ]
            });
        }
        $('#modal-cantidad').on('show.bs.modal', function(e){
            $(".modal-dialog").css("width", "50%");
            var tipo = $(e.relatedTarget).data().tipo;
            var idreg = $(e.relatedTarget).data().idreg;
            var idprod = $(e.relatedTarget).data().idprod;
            var url = "consulta_modal_cant.php"; //por crear -> ya creado
            $.ajax({
                type: "POST",
                url: url,
                data:{
                    tipo:tipo,
                    idreg:idreg,
                    idprod:idprod
                },
                success: function(respuesta){
                    var array = eval(respuesta);
                    $("#id_receta").val(array[0]);
                    $("#clave_receta").val(array[1]);
                    $("#tipo").val(array[2]);
                    $("#cantidad_prod").val("");
                }
            })
        })
        $('#btn-Guardar').click(function() {
            if ($("#cantidad_prod").val() == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_cantidad.php";
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:$("#form-modal").serialize(),
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-cantidad').modal('hide');
                        }else if(respuesta == "ok_modifica"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-cantidad').modal('hide');
                        }
                        else{
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

        $('#lista_articulos').on('change', 'input',function () {
           var val = $(this).val(); 
           var data = $('#lista_articulos').DataTable().row($(this).parents('tr')).data();
           if (val == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_cantidad.php";
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:{
                        clave_receta: data["artc_articulo"],
                        cantidad_prod: val
                    },
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-cantidad').modal('hide');
                        }else if(respuesta == "ok_modifica"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-cantidad').modal('hide');
                        }
                        else{
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
	</script>
</body>

</html>