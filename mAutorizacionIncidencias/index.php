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
            <h3 class="box-title">Incidencias Pendientes | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_registros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="35%">No. Empleado</th>
                         <th width="35%">Departamento</th>
                         <th width="35%">Sucursal</th>
                        <th width="15%">Incidencia</th>
                        <th width="15%">Comentario</th>
                        <th width="20%">Autorizar</th>
                        <th width="5%">Rechazar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th>No. Empleado</th>
                        <th>Departamento</th>
                        <th>Sucursal</th>
                        <th>Incidencia</th>
                        <th>Comentario</th>
                        <th>Autorizar</th>
                        <th>Rechazar</th>
                      </tr>
                    </tfoot>
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
  <?php include 'modal_pagar.php'; ?>
  <?php include 'modal_rechazar.php'; ?>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
  $( document ).ready( function () {
    cargar_tabla();
  });
  function cargar_tabla(){
    $('#lista_registros').dataTable().fnDestroy();
    $('#lista_registros').DataTable( {
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
        "url": "tabla_pendientes.php",
        //http://200.1.1.197/SMPruebas/mAutorizacionIncidencias/
        "dataSrc": ""
      },
      "columns": [
        { "data": "id" },
        { "data": "nombre" },
        { "data": "departamento" },
        { "data": "sucursal" },
        { "data": "incidencia" },
        { "data": "comentario"},
        { "data": "activo"},
        { "data": "rechazar"},
      
      ]
    });
  }
  //modal para adjuntar archivos.
  $('#modal-default').on('show.bs.modal', function(e) {
    var id_registro = $(e.relatedTarget).data().id;
    var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.http://200.1.1.197/SMPruebas/mAutorizacionIncidencias/
      $.ajax({
        type: "POST",
        url: url,
        data: {id_registro:id_registro}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);

          $('#nombre').html(array[0]);
          $('#incidencia').val(array[2]);
          $('#id_registro').val(array[1]);
          $('#accion').val(array[3]);
          $('#comentario').val(array[4]);
        }
      });
    });
    $(function () {
    $('#decision').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "combo_decision.php",
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
  });
    $('#modal-rechazar').on('show.bs.modal', function(e) {
    var id_registroo = $(e.relatedTarget).data().id;
    var url = "consulta_datos_modall.php"; // El script a dónde se realizará la petición.http://200.1.1.197/SMPruebas/mAutorizacionIncidencias/
      $.ajax({
        type: "POST",
        url: url,
        data: {id_registroo:id_registroo}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);
         
          $('#nombre_persona').html(array[0]);
          $('#registro').val(array[3]);//incidencia
          $('#id_registroo').val(array[1]);
          $('#sugerencia').val(array[5]);
          $('#comentario_inicio').val(array[6]);
          $('#folio').val(array[6]);
        }
      });
    });

  $("#btn-autorizar").click(function(){
      var id_registro= $('#id_registro').val();
      var decision =$('#decision').val();
      var comentario_fin =$('#comentario_fin').val();
        var url = "autorizacion.php";
        $.ajax({
          type: "POST",
          url: url,
          data:{ id_registro:id_registro, 'decision':decision,'comentario_fin':comentario_fin},
          success: function(respuesta) {
            if($('#decision').val().length == 0){
              alertify.error("Verifica Campos");
            }
            else if (respuesta=="ok") {
              alertify.success("Incidencia Autorizada");
              cargar_tabla();
              $('#modal-default').modal('hide');
            } else if(respuesta=="ok_actualizado"){
                    alertify.success("Registro actualizado correctamente");
                  }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
    });
  
    $("#btn-rechazar").click(function(){
      var id_registroo= $('#id_registroo').val();
      var comentario_final =$('#comentario_final').val();
      var folio =$('#folio').val();
        var url = "reechazar.php";
        $.ajax({
          type: "POST",
          url: url,
          data:{ id_registroo:id_registroo, 'comentario_final':comentario_final,'folio':folio},
          success: function(respuesta) {
            if($('#comentario_final').val().length == 0){
              alertify.error("Verifica Campos");
            }
            else if (respuesta=="ok") {
              alertify.success("Incidencia Rechazada");
              cargar_tabla();
              $('#modal-rechazar').modal('hide');
            } else if(respuesta=="ok_actualizado"){
                    alertify.success("Registro actualizado correctamente");
                  }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
    });
</script>
</html>
