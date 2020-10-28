<?php
	include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
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
			<div class="box box-danger" <?php echo $solo_lectura ?>>
				<div class="box-header">
					<h3 class="box-title">Cargar Meta-Data</h3>
				</div>
				<div class="box-body">
  				<form method="POST" id="form_datos" enctype="multipart/form-data">
            <div class="row">
  						<div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha">*Descripcion:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control">
                  </div>
                </div>
  							<div class="col-md-6">
  								<div class="form-group">
  									<label for="fecha">*Seleciona Archivo XML:</label>
  									<input type="file" name="archivo" id="archivos">
  								</div>
  							</div>
  						</div>
  					</div>
  					<div class="box-footer text-right">
  						<button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
  					</div>
  				</form>
				</div>
			</div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Gastos Guardados</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="lista_gastos" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="5%">#</th>
                  <th>Descripcion</th>
                  <th>Fecha</th>
                  <th width="5%">Ver</th>
                  <th width="5%">Eliminar</th>
                </tr>
              </thead>
              <tfooter>
                <tr>
                  <th width="5%">#</th>
                  <th>Descripcion</th>
                  <th>Fecha</th>
                  <th>Ver</th>
                  <th>Eliminar</th>
                </tr>
              </tfooter>
            </table>
          </div>
        </div>
        <div class="box-footer"></div>
      </div>
			<div class="box box-danger">
				<div class="box-header">
					<h3 class="box-title">Lista de Gastos Guardados</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table id="lista_gastos_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="5%">#</th>
                  <th>Uuid</th>
                  <th>RFC Emisor</th>
                  <th>Nombre Emisor</th>
                  <th>Fecha Emision</th>
                  <th>Fecha Certificacion Sat</th>
                  <th>Monto</th>
                  <th>Efecto Comprobante</th>
                  <th>Eliminar</th>
								</tr>
							</thead>
							<tfooter>
								<tr>
									<th width="5%">#</th>
                  <th>Uuid</th>
                  <th>RFC Emisor</th>
                  <th>Nombre Emisor</th>
                  <th>Fecha Emision</th>
                  <th>Fecha Certificacion Sat</th>
                  <th>Monto</th>
                  <th>Efecto Comprobante</th>
                  <th>Eliminar</th>
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
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include '../footer.php'; include 'modal_rancho.php'; include 'modal_rublo.php';?>
<!-- Page script -->
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script>
  function estilo_tablas () {
    $('#lista_gastos').dataTable().fnDestroy();
    $('#lista_gastos').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
              title: 'Lista Invitados',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Invitados',
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
            "url": "tabla_gastos.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "#" },
            { "data": "Descripcion" },
            { "data": "Fecha" },
            { "data": "Ver" },
            { "data": "Eliminar" }
        ]
    });
   }  
  function estilo_tablas1(folio) {
    $('#lista_gastos_detalle').dataTable().fnDestroy();
    $('#lista_gastos_detalle').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
              title: 'Lista Invitados',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Invitados',
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
            "url": "tabla_gastos_detalle.php",
            "dataSrc": "",
            "data":{'folio':folio},
        },
        "columns": [
            { "data": "#" },
            { "data": "Uuid" },
            { "data": "RFCE" },
            { "data": "NEmisor" },
            { "data": "FEmision" },
            { "data": "FCS" },
            { "data": "Monto" },
            { "data": "EC" },
            { "data": "Eliminar" }
        ]
    });
   }  
  $(function (){
    estilo_tablas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
        $.ajax({
          type: "POST",
          url: 'leer.php',
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false
        })
        .done(function(res){
          if (res == "ok"){
            alertify.success("Registros Guardados Correctamente");
            $('#form_datos')[0].reset();
            estilo_tablas();
          }else if(res == "vacio"){
            alertify.error("Verifica Campos");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          archivos: "required",
          descripcion: "required"
        },
        messages: {
          archivos: "Campo requerido",
          descripcion: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      });
    });
  $('#modal-default').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data().id;
    tabla_ranchos();
  });
  $("#guardar_modal").click(function(){
    var url = "insertar_rublo.php";
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: $('#form_datos_rublo').serialize(),
      success: function(respuesta) {
        if (respuesta=="ok") {
        alertify.success("Registro Guardado Correctamente");
        $('#rublo_modal').val("");
        $('#id_registro_modal').val("0");
        cargar_tabla_modal();
        }else if(respuesta == "duplicado"){
          alertify.error("Registro Existente");
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
    return false;
  });
  function cargar_tabla_modal(){
    $('#lista_rublos').dataTable().fnDestroy();
    $('#lista_rublos').DataTable({
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":false,
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
              title: 'Lista Rublos',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Rublos',
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
        "url": "tabla_rublo.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Editar" },
        { "data": "Eliminar" }
      ]
    });
  }
  function editar_rublo(id){
    $.ajax({
      url: 'editar_rublo.php',
      data: '&id='+ id,
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        nombre  = array[0];

        $('#id_registro_modal').val(id);
        $('#rublo_modal').val(nombre);

      }
    });
  }
  function eliminar_rublo(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_registro.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if (respuesta = "ok"){
              alertify.success("Registro Eliminado Correctamente");
              cargar_tabla_modal();
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      } 
    });
  } 
  $('#modal-default1').on('show.bs.modal', function(e) {
    cargar_tabla_modal();
    });
  $(function () {
    $('#tipo_rancho').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    });
    $('#estado').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    });
    $('#municipio').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    });
  });
  $("#btn-guardar").click(function(){
    $.ajax({
      url: "guardar.php",
      type: "POST",
      dateType: "html",
      data: $('#form_rancho').serialize(),
      success: function(respuesta) {
        if(respuesta == "ok"){
          $("#form_rancho")[0].reset();
          $('#tipo_rancho').val("").trigger('change.select2');
          $('#estado').val("").trigger('change.select2');
          $('#municipio').val("").trigger('change.select2');
          alertify.success("Registro Guardado Correctamente");
          tabla_ranchos();
        }else if(respuesta == "duplicado"){
          alertify.error("Registro Duplicado");
        }else if(respuesta == "vacio"){
          alertify.error("Verifica Campos");
        }else{
          alertify.error("Ha Ocurrido un Error");
        }        
      }
    });
    return false;
  });
  function tabla_ranchos() {
    $('#lista_ranchos').dataTable().fnDestroy();
    $('#lista_ranchos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
            title: 'Lista Ranchos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Lista Ranchos',
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
        "url": "tabla_rancho.php",
        "dataSrc": "",
        "data" :{}
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Tipo" },
        { "data": "Estado" },
        { "data": "Municipio" },
        { "data": "Encargado" },
        { "data": "Editar" },
        { "data": "Eliminar" }
      ]
    });
  }
  function eliminar_rancho(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_rancho.php',
          data: '&id='+id ,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Registro Eliminado');
              tabla_ranchos();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
           }
        });
      }
    });
  }
  function editar_rancho(id){
    $.ajax({
      url: 'editar_rancho.php',
      data: '&id='+ id,
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        $('#id_rancho').val(id);

        $('#nombre_rancho').val(array[0]);
        $('#tipo_rancho').val(array[1]).trigger('change.select2');
        $('#estado').val(array[2]).trigger('change.select2');
        $('#municipio').val(array[3]).trigger('change.select2');
        $('#encargado_rancho').val(array[4]);
      }
    });
  }
  $(":file").filestyle('buttonText', 'Seleccionar');
  $(":file").filestyle('size', 'sm');
  $(":file").filestyle('input', true);
  $(":file").filestyle('disabled', false);
</script>
</body>
</html>

