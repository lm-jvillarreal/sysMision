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
    <style>
      .modal {
        text-align: center;
        padding: 0!important;
      }
       
      .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
      }
       
      .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
      }
    </style>
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
      <div class="box box-danger" <?php echo $solo_lectura; ?>>
        <div class="box-header">
          <h3 class="box-title">Registro de Actividades</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            </a>
          </div>
        </div>
        <div class="box-body">
          <!-- <form id="form-datos" method="POST"> -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="actividad">*Actividad</label>
                  <input type="text" name="actividad" id="actividad" class="form-control" placeholder="Nombre de la Actividad" onkeyup="if(event.keyCode == 13)guardar();">
                </div>
              </div>
              <!-- <div class="col-md-6">
                <div class="form-group">
                  <label for="descripcion">*Descripcion</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion de Actividad">
                </div>
              </div> -->
            </div>
            <!-- <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
            </div> -->
          <!-- </form> -->
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Actividades</h3>
          <div class="box-tools pull-right">
            <a onclick="estilo_tablas();">
              <i class="fa fa-refresh fa-spin"></i>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </a>
          </div>
          <br>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="5%">Datos</th>
                      <th width="5%">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="10%">Datos</th>
                      <th width="5%">Eliminar</th>
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
 <?php include '../footer2.php'; ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php'; include 'modal.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  $('#actividad').focus();
  function estilo_tablas() {
    $('#lista_actividades').dataTable().fnDestroy();
    $('#lista_actividades').DataTable( {
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
            title: 'ListaActividades',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'ListaActividades',
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
        "url": "tabla_actividades2.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Iniciar" },
        { "data": "Eliminar" },
      ]
    });
  }  
  $(function (){
   estilo_tablas();
  });
  $('#modal-default').on('show.bs.modal', function(e) {
       $('#btn2').focus();
    });
    function guardar(){
      var actividad = $('#actividad').val();
      $.trim(actividad);
      if(actividad == ""){
        $('#actividad').focus();
      }else{
        $('#modal-default').modal('show');
      }
    }
    function guardar1(cronometro){
      var actividad = $('#actividad').val();
      var usuario   = $('#usuario').val();
      $.trim(actividad);
      if(actividad == ""){

      }else{
        $.ajax({
          url: 'insertar_actividad2.php',
          type: "POST",
          dateType: "html",
          data: {'actividad':actividad,'cronometro': cronometro,'usuario':usuario},
          success: function(respuesta) {
            if (respuesta=="ok") {
              $('#actividad').val("");
              $('#actividad').focus();
              alertify.success("Registro guardado correctamente");
              estilo_tablas();
              $('#modal-default').modal('hide');
              if ($('#form_usuario').is(':visible')) {
                  activar();
              }else{
                  //$('#elemento').show();
              }
            }
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
      }
    }
    function completar(folio){
      $.ajax({
        url: 'completar_actividad.php',
        type: "POST",
        dateType: "html",
        data: {'folio':folio},
        success: function(respuesta) {
          alertify.success("Actividad Completada");
          estilo_tablas();
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
    function terminar(id){
      $.ajax({
        url: 'terminar_actividad.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          alertify.success("Actividad Terminada");
          estilo_tablas();
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
    function iniciar(id){
      $.ajax({
        url: 'iniciar_actividad.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          alertify.success("Actividad Iniciada");
          estilo_tablas();
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
    function eliminar(id){
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
                estilo_tablas();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        } 
      });
    }
    function mostrar(numero){
      if ($('#inputactividad_'+numero).hasClass('hidden')){
        $('#inputactividad_'+numero).removeClass('hidden');  
      }
      else{
        $('#inputactividad_'+numero).addClass('hidden');
      }
    }
    function editar_act(numero,id) {
      var actividad = $('#inputactividad_'+numero).val();
      $.ajax({
        url: 'actualizar_registro.php',
        data: {'actividad':actividad,'id':id},
        type: "POST",
        success: function(respuesta) {
          if (respuesta = "ok"){
            alertify.success("Registro Actualizado Correctamente");
            estilo_tablas();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }
    function activar(){
      $('#form_usuario').toggle();  
      $('#btn1').toggle();
      $('#btn2').toggle();
      $('#t1').toggle();
      $('#t2').toggle();
      $("#usuario").select2("trigger", "select", {
        data: { id: '', text:'' }
      });
    }
    $('.form_date').datetimepicker({
      language:  'es',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $(function () {
      $('#usuario').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
         url: "consulta_usuarios.php",
         type: "post",
         dataType: 'json',
         delay: 250,
         data: function (params) {
          return {
            searchTerm: params.term
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
    // $('cuerpo2').keyup(function(e) {
    //   if(e.which == 13){
    //     alert("hola") ;
    //   }
    // });  
  </script>
</body>
</html>