<?php
  include '../global_seguridad/verificar_sesion.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
		<div class="box box-danger">
			<div class="box-header">
				<h3 class="box-title">Lista de Cambios Físicos | Cambios Pendientes</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table id="lista_cambios_liberados" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
				            <tr>
				                <th width="5%">Folio</th>
				                <th>Proveedor</th>
				                <th width="40%">Producto</th>
												<th width="5%">Cantidad</th>
												<th width="5%">Sucursal</th>
				                <th width="5%">Liberado</th>
				            </tr>
				        </thead>
				        <tfooter>
				        	<tr>
								<th>Folio</th>
								<th>Proveedor</th>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Sucursal</th>
								<th>Liberado</th>
				            </tr>
				        </tfooter>
					</table>
				</div>
			</div>
			<div class="box-footer"></div>
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

<?php include '../footer.php'; ?>
<!-- Page script -->
<script>
  function liberar_cambioFisico(id_cambio){
  	//var id_devolucion = "";
    swal({
      title: "¿Está seguro de liberar el cambio fisico?",
      text: "No. cambio: "+id_cambio,
      icon: "warning",
      buttons: ["Cancelar", "Liberar"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        cambiar_status(id_cambio);
        swal("El cambio físico no."+ id_cambio+" ha sido liberado.", {
          icon: "success",
        });
        cargar_tabla();
       } else {
        swal("El cambio físico no. "+id_cambio+" ha sido cancelado.",{
          icon: "error",
        });
        cargar_tabla();
      }
    });
  }
	function cambiar_status(id){
		var url = "liberar_cambioFisico.php"; // El script a dónde se realizará la petición.
		$.ajax({
			type: "POST",
			url: url,
			data: {ide:id}, // Adjuntar los campos del formulario enviado.
			success: function(respuesta)
			{
				console.log(respuesta);
			}
		});
		// Evitar ejecutar el submit del formulario.
		return false;
	}
	function cargar_tabla(){
		var proveedor = $("input[name='proveedor']").val();
		$('#lista_cambios_liberados').dataTable().fnDestroy();
		$('#lista_cambios_liberados').DataTable({
		    'language': {"url": "../plugins/DataTables/Spanish.json"},
				"paging":   false,
		    "ajax": {
		        "type": "POST",
		        "url": "tabla_cambiosLiberados.php",
		        "dataSrc": "",
		        "data": {proveedor: proveedor}
		    },
		    "columns": [
		      	{ "data": "folio" },
		        { "data": "proveedor" },
		        { "data": "producto" },
		        { "data": "cantidad" },
						{ "data": "sucursal" },
		        { "data": "liberado" }
		    ]
		});
	}
	$( document ).ready(function() {
		cargar_tabla();
		
	})
  </script>
</body>
</html>
