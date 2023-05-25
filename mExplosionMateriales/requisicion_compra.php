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
						<h3 class="box-title">Explosión de materiales | Requisición para compra </h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='5%'>Artículo</th>
                                                <th width='5%'>Insumo</th>
												<th width='5%'>Proveedor</th>
												<th width='15%'>Cantidad requerida</th>
												<th width='15%'>Días de entrega</th>
												<th>Qty req</th>
                                                <th>Cantidad por ordenar</th>
												<th>Factor de empaque</th>
                                                <th>Costo UM</th>
                                                <th>Costo total</th>
												<!--th>Acciones</th-->
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
		<?php include 'modal_req.php'; ?>
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
                    }
                ],
                "ajax": {
                    "type": "POST",
                    "url": "tabla_requisicion_compra.php",
                    "dataSrc": "",
                    "data": ""
                },
                "columns": [{
                        "data": "artc_articulo"
                    },
                    {
                        "data": "artc_descripcion"
                    },
                    {
                        "data": "proveedor"
                    },
					{
						"data": "minimo_inv"
					},
					{
						"data": "dias_req"
					},
					{
						"data": "holder"
					},
					{
						"data": "cant_req"
					},
                    {
                        "data": "factor_empaque"
                    },
                    {
                        "data": "rmon_ultimoprecio"
                    },
                    {
                        "data": "costo_total"
                    }/*,
					{
                        "data": "acciones"
                    }*/]
            });
        }
		// function InsertarReq(){
		// 	if($("#artc_articulo").val() == "" || $("#dias_entrega").val() == "" || $("#cantidad_ordenar").val() == "")
		// 	{
		// 		alertify.error("Existen campos vacíos");
      	// 	}else
		// 	{
        //     	$.ajax({
		// 			url: 'insertar_requisicion.php',
        //     		type: "POST",
        //     		dateType: "html",
        //     		data: $("#form-datos").serialize(),
        //      		success: function(respuesta) {
        //         		if (respuesta == "ok_nuevo") {
        //           			alertify.success("Registro guardado correctamente");
        //         		} else if (respuesta == "ok_modifica") {
        //          			alertify.success("Registro actualizado correctamente");
        //         		} else if (respuesta == "duplicado") {
        //           			alertify.error("El registro ya existe");
        //         		} else {
        //           			alertify.error("Ha ocurrido un error");
        //         		}
        //         		$("#artc_articulo").val(''); //Limpiar los campos tipo Text
		// 				$("#dias_entrega").val('');
		// 				$("#cantidad_ordenar").val('');
        //         		cargar_tabla();
        //       		}
        //     	});
		// 	}
        //     // Evitar ejecutar el submit del formulario.
        //     return false;
        // }
		$('#modal-req').on('show.bs.modal', function(e){
            $(".modal-dialog").css("width", "50%");
            var tipo = $(e.relatedTarget).data().tipo;
            var idreg = $(e.relatedTarget).data().idreg;
            var idprod = $(e.relatedTarget).data().idprod;
            var url = "consulta_modal_req.php"; //por crear
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
                    $("#articulo").val(array[1]);
                    $("#dias_entrega").val(array[2]);
                    $("#cantidad_ordenar").val("");
                }
            })
        })
        $('#btn-Guardar').click(function() {
            if ($("#dias_entrega").val() == "" || $("#cantidad_ordenar").val() == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_requisicion.php";
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:$("#form-modal").serialize(),
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Registro añadido correctamente");
                            $('#modal-req').modal('hide');
                        }else if(respuesta == "ok_modifica"){
                            alertify.success("Registro añadido correctamente");
                            $('#modal-req').modal('hide');
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


            var dias = $('#lista_articulos').DataTable().cell($(this).parents('tr'),4).nodes().to$().find('input').val();
            var cantidad = $('#lista_articulos').DataTable().cell($(this).parents('tr'),6).nodes().to$().find('input').val();
            //console.log(val);
            console.log(data);
            //console.log(data['dias']);
            //console.log(data['cantidad']);
            //console.log(data['cant_req']);
            //console.log(data['dias_req']);
            //console.log("///////////");
            ///!!!!No borrar¡¡¡¡

            if (val == "" || dias == "" || cantidad == "") {
                alertify.error("Existen campos vacíos");
            }else{
                var url = "insertar_requisicion.php";
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:"html",
                    data:{
                        articulo: data['artc_articulo'],
                        dias_entrega: dias,
                        cantidad_ordenar: cantidad 
                    },
                    success:function (respuesta) {
                        if(respuesta == "ok"){
                            alertify.success("Registro añadido correctamente");
                            $('#modal-req').modal('hide');
                        }else if(respuesta == "ok_modifica"){
                            alertify.success("Registro añadido correctamente");
                            $('#modal-req').modal('hide');
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