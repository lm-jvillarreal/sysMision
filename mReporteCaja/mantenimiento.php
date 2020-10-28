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
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <div class="box-header">
            <h3 class="box-title">Mantenimiento de Caja | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Sucursal:</label>
                    <select name="id_sucursal" id="id_sucursal" style="width: 100%"></select>
                    <input type="text" name="id_registro" id="id_registro" value="0" class="hidden">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Caja:</label>
                    <select name="id_caja" id="id_caja" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Equipo:</label>
                    <select name="id_equipo" id="id_equipo" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Comentarios:</label>
                    <input type="text" name="comentarios" id="comentarios" class="form-control" placeholder="Comentarios ...">
                  </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="imagen">*Imagen:</label>
                        <input id="file-es" name="file-es[]" type="file" multiple>
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
            <h3 class="box-title">Lista de Mantenimientos</h3>
          </div>
          <div class="box-body" onmouseover="efecto();">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_reportes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Caja</th>
                        <th>Equipo</th>
                        <th>Comentario</th>
                        <th>IMG</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>  
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

<?php include '../footer.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
<script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>
<!-- Page script -->
<script>
    function efecto(){
      var test = $('.venobox').venobox();
        // close current item clicking on .closeme
        $(document).on('click', '.closeme', function(e){
            test.VBclose();
        });
        // go to next item in gallery clicking on .next
        $(document).on('click', '.next', function(e){
            test.VBnext();
        });
        // go to previous item in gallery clicking on .previous
        $(document).on('click', '.previous', function(e){
            test.VBprev();
        });
    }
    $('#id_sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_sucursales.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    })
    $('#id_caja').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_cajas2.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var id_sucursal = $('#id_sucursal').val();
                return {
                    searchTerm: params.term, // search term
                    id_sucursal:id_sucursal
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    })
    $('#id_equipo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_equipos.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var id_caja = $('#id_caja').val();
                return {
                    searchTerm: params.term, // search term
                    id_caja:id_caja
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    })
    function cargar_tabla() {
      $('#lista_reportes').dataTable().fnDestroy();
      $('#lista_reportes').DataTable( {
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
              title: 'Control Equipos',
              exportOptions: {
              columns: ':visible'
              }
          },
          {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Control Equipos',
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
          "url": "tabla_mantenimientos.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Sucursal", "width":"10%" },
          { "data": "Caja", "width":"10%" },
          { "data": "Equipo", "width":"10%" },
          { "data": "Comentario" },
          { "data": "IMG", "width":"3%" },
          { "data": "Editar", "width":"3%" },
          { "data": "Eliminar", "width":"3%" }
        ]
      });
    }
    cargar_tabla();
    $.validator.setDefaults( {
      submitHandler: function () {
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
       	$.ajax({
          type: "POST",
          url: 'guardar_mantenimiento.php',
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
            cargar_tabla();
            $("#id_sucursal").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#id_caja").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#id_equipo").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#comentarios').val("");
          }else if (res == "oks"){
            alertify.success("Registros Guardados Correctamente (Sin Imagen)");
            $('#form_datos')[0].reset();
            cargar_tabla();
            // $("#id_proveedor").select2("trigger", "select", {
            //   data: { id: '', text:'' }
            // });
            $("#supervisor").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#rublo").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#id_sucursal").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
          }
          else{
            alertify.error("Ha Ocurrido un Error");
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate({
        rules: {
          id_sucursal: "required",
          id_caja: "required",
          id_equipo: "required",
          comentarios: "required"
        },
        messages: {
          id_sucursal: "Campo requerido",
          id_caja: "Campo requerido",
          id_equipo: "Campo requerido",
          comentarios: "Campo requerido"
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
          $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
          $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
          $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      });
    });
    function eliminar(id){
      swal({
        title: "¿Está Seguro de Eliminar Reporte?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_mant.php',
            data: {'id':id} ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                cargar_tabla();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        }
      });
    }
    function editar(id){
      $.ajax({
        url: 'editar2.php',
        data: {'id':id},
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(id);
          $("#id_sucursal").select2("trigger", "select", {
            data: { id: array[0], text:array[1] }
          });
          $("#id_caja").select2("trigger", "select", {
            data: { id: array[2], text:array[3] }
          });
          $("#id_equipo").select2("trigger", "select", {
            data: { id: array[4], text:array[5] }
          });
          $('#comentarios').val(array[6]);
        }
      });
    }
    $("#file-es").fileinput({
  		language: 'es',
  		browseClass: "btn btn-danger",
  		fileType: "jpg",
  		allowedFileExtensions: ['jpg','jpeg'],
  		uploadUrl: 'guardar_mantenimiento.php',
  		uploadAsync: false,
  		maxFileCount: 5,
  		maxFileSize: 10000,
  		showUpload: false,
  		removeFromPreviewOnError: true
  	});
</script>
</body>
</html>
