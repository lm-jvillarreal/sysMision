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
						<h3 class="box-title">Costeo de Carnicería | Catálogo de cortes</h3>
					</div>
					<form action="" method="POST" id="form-datos">
						<div class="box-body">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="artc_articulo">*Código:</label>
										<input type="text" name="artc_articulo" id="artc_articulo" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="artc_descripcion">*Descripción</label>
										<input type="text" name="artc_descripcion" id="artc_descripcion" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="box-footer text-right">
						<button class="btn btn-danger" id="btn-guardar">Guardar Registro</button>
					</div>
				</div>
				<div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Catálogo de cortes | Lista de Registros Existentes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id='lista_cortes' class='table table-striped table-bordered' cellspacing='0' width='100%'>
										<thead>
											<tr>
												<th width='5%'>#</th>
												<th width='15%'>Código</th>
												<th>Corte</th>
												<th width='5%'></th>
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
		<?php include 'modal_corterenglones.php'; ?>
		<!-- /.content-wrapper -->
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
      $("#artc_articulo").focus();
		});
		$("#btn-guardar").click(function() {
			if ($("#artc_articulo").val() == "" || $("#artc_descripcion").val() == "") {
				alertify.error("Existen campos vacíos");
			} else {
				var url = "insertar_corte.php";
				$.ajax({
					url: url,
					type: "POST",
					dateType: "html",
					data: $("#form-datos").serialize(),
					success: function(respuesta) {
						alertify.success("Corte insertado correctamente");
						$('#form-datos')[0].reset();
						$("#artc_articulo").focus();
						cargar_tabla();
					},
					error: function(xhr, status) {
						alert("error");
					}
				});
			}
			//cargar_tabla();
			return false;
		});

		function cargar_tabla() {
			$('#lista_cortes').dataTable().fnDestroy();
			$('#lista_cortes').DataTable({
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
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_cortes.php",
					"dataSrc": "",
					"data": ""
				},
				"columns": [{
						"data": "id"
					},
					{
						"data": "artc_codigo"
					},
					{
						"data": "artc_corte"
					},
					{
						"data": "opciones"
					}
				]
			});
		}
    function cargar_tabla_modal(id_catalogo){
      $('#lista_detalle').dataTable().fnDestroy();
			$('#lista_detalle').DataTable({
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
				],
				"ajax": {
					"type": "POST",
					"url": "tabla_corterenglones.php",
					"dataSrc": "",
					"data": {
            id_catalogo: id_catalogo
          }
				},
				"columns": [{
						"data": "id",
						"width": "5%"
					},
					{
						"data": "artc_codigo",
						"width": "15%"
					},
					{
						"data": "artc_corte"
					},
					{
						"data": "opciones",
						"width": "5%"
					}
				]
			});
    };
		$('#modal_corterenglones').on('show.bs.modal', function(e) {
			$(".modal-dialog").css("width", "95%");
			var folio = $(e.relatedTarget).data().folio;
			//alert(id);
			var url = "detalle_modalcorte.php"; // El script a dónde se realizará la petición.
      var origen="1";
			$.ajax({
				type: "POST",
				url: url,
				data: {
					folio: folio,
          origen: origen
				}, // Adjuntar los campos del formulario enviado.
				success: function(respuesta) {
					var array = eval(respuesta);
					$("#id_corte").val(array[0]);
					$("#modal_clavecorte").val(array[1]);
					$("#modal_descripcioncorte").val(array[2]);
					$("#modal_articulo").focus();
					cargar_tabla_modal(array[0]);
				}
			});
		});
		$("#modal_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_descripcion.php"; // El script a dónde se realizará la petición.
        var id_corte = $("#id_corte").val();
        var corte=$("#modal_clavecorte").val();
        var artc_articulo = $("#modal_articulo").val();
				var origen='2';
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            artc_articulo: artc_articulo,
						origen: origen
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              $("#modal_articulo").focus();
              swal("el artículo no existe", "", "warning");
            } else {
              var array = eval(respuesta);
              $("#modal_descripcion").val(array[0]);
              insertarRenglon(id_corte, corte, artc_articulo);
            }
          }
        });
        return false;
      }
    });
    function insertarRenglon(id_catalogo, corte, artc_articulo){
      var url='insertar_renglon.php';
      $.ajax({
        type: "POST",
        url: url,
        data:{
          id_corte: id_catalogo,
          corte: corte,
          artc_articulo: artc_articulo
        },
        success: function(respuesta){
          cargar_tabla_modal(id_catalogo);
          $("#modal_articulo").val('');
          $("#modal_descripcion").val('');
          $("#modal_articulo").focus();
        }
      })
    }

		function eliminar(id_renglon){
			var url="eliminar_renglon.php";
			$.ajax({
				type: "POST",
        url: url,
        data:{
          id_renglon
        },
        success: function(respuesta){
          alertify.success("Artículo eliminado");
					cargar_tabla_modal($("#id_corte").val());
        }
			})
		}
	</script>
</body>

</html>