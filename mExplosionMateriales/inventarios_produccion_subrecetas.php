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
						<h3 class="box-title">Explosión de materiales | InvPro-Sub-Recetas</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
                                                <th width='10%'>Articulo</th>
												<th width=''>Descripción</th>
												<th width='15%'>Inv. Min.</th>
												<!--th width='10%'>Agregar Inventario</th-->
												<th width='15%'>Existencias</th>
                                                <th width='10%'>Producción (KG)</th>
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
	<?php include 'modal_subr.php'; ?>
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
                    "url": "tabla_invpro_subrecetas.php",
                    "dataSrc": "",
                    "data": ""
                },
                "columns": [{
                        "data" : "clave_receta"
                    },
                    {
                        "data": "nombre_receta"
                    },
                    {
                        "data": "minimo_jc"
                    }/*,
					{
                        "data": "agregar"
                    }*/,
                    {
                        "data": "existencias"
                    },
                    {
                        "data": "produccion"
                    }
                ]
            });
        }
		$('#modal-subrecetas').on('show.bs.modal', function(e){
            $(".modal-dialog").css("width", "50%");
            var idreg = $(e.relatedTarget).data().idreg;
            var idprod = $(e.relatedTarget).data().idprod;
            var url = "consulta_modal_subr.php"; //por crear
            $.ajax({
                type: "POST",
                url: url,
                data:{
                    idreg:idreg,
                    idprod:idprod
                },
                success: function(respuesta){
                    var array = eval(respuesta);
                    $("#id_registro").val(array[0]);
                    $("#id_articulo").val(array[2]);
                    $("#descripcion").val(array[1]);
                    $("#cantidad_subr").val("");
                }
            })
        })
        $('#btn-Guardar').click(function() {
            if ($("#cantidad_subr").val() == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_cantidad_subr.php";//por crear
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:$("#form-modal").serialize(),
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-subrecetas').modal('hide');
                        }else if(respuesta == "ok_modifica"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-subrecetas').modal('hide');
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

        $('#lista_articulos').on('change', 'input', function () {
            var val = $(this).val();
            var data = $('#lista_articulos').DataTable().row($(this).parents('tr')).data();
            console.log(val);
            console.log(data['clave_receta']);
            console.log(data);
            console.log("///////////");
            ///!!!!No borrar¡¡¡¡
            if (val == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_cantidad_subr.php";//por crear
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:{
                        id_articulo : data['clave_receta'],
                        cantidad_subr : val
                    },
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-subrecetas').modal('hide');
                        }else if(respuesta == "ok_modifica"){
                            alertify.success("Cantidad añadida correctamente");
                            $('#modal-subrecetas').modal('hide');
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