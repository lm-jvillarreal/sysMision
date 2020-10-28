<?php
  include '../global_seguridad/verificar_sesion.php';

  date_default_timezone_set('America/Monterrey');
  $fecha = date("Y-m-d");  
  $hora  = date ("h:i:s");

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
    <?php include 'menuV2.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger" id="agenda_hoy">
        <div class="box-header">
          <h3 class="box-title"><b>Promotores Para Hoy</b></h3>
        </div>
        <div class="box-body">
          <div class="row" id="lista_promotores">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_promotores_hoy" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th width="20%">Nombre</th>
                      <th width="15%">Compañia</th>
                      <th width="15%">Telefono</th>
                      <th width="10%">Horario</th>
                      <th width="10%">Iniciar</th>
                      <th width="10%">Terminar</th>
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
                    </tr>
                  </tbody>  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ////////////////////////////////INFO PROMOTOR///////////////// -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'modal_promotor.php'; ?>
  <?php include '../footer2.php'; ?>
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include '../footer.php'; ?>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
  function estilo_tablas() {
    $('#lista_promotores_hoy').dataTable().fnDestroy();
    $('#lista_promotores_hoy').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_promotores_hoy.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Compañia" },
        { "data": "Telefono" },
        { "data": "Horario" },
        { "data": "Iniciar" },
        { "data": "Terminar" }
      ]
    });
   }
   function estilo_tablas1(id_promotor) {
    $('#lista_actividades_promotor').dataTable().fnDestroy();
    $('#lista_actividades_promotor').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_actividades_promotor.php",
        "dataSrc": "",
        "data":{'id_promotor':id_promotor},
      },
      "columns": [
        { "data": "#" },
        { "data": "Actividad" },
        { "data": "Inicio" },
        { "data": "Fin" },
        { "data": "Duracion" },
        { "data": "Iniciar" }
      ]
    });
   }
   function iniciar_actividad(id_actividad){
      $.ajax({
        type: "POST",
        url: 'iniciar_actividad.php',
        data: {'id_actividad':id_actividad}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);

          if(array[0] == "ok"){
            alertify.success("Actividad Comenzada");
          }else if(array[0] == "ok2"){
            if(array[2] == "1"){
              $('#cajas').show();
            }
            alertify.success("Actividad Terminada");
            $('#form').hide();
            $('#form_terminar').show();
            $('#id_actividad_modal').val(id_actividad);
          }
          estilo_tablas1(array[1]);
        }
      });
   }
   function insertar_act(actividad, id_promotor){
    actividad.trim();
    if (actividad != ""){
      $.ajax({
        type: "POST",
        url: 'add_actividad.php',
        data: {'actividad':actividad,'id_promotor':id_promotor}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#actividad').val("");
          alertify.success("Actividad Añadida Correctamente");
          estilo_tablas1(id_promotor);
        }
      });
    }else{
      alertify.error("Verifica Campo");
    }
   }
   estilo_tablas();
   $('#modal-default').on('show.bs.modal', function(e) {
       var id_agenda = $(e.relatedTarget).data().id;
       var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {id_agenda:id_agenda}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            var array = eval(respuesta);
            $('#id_promotor_modal').val(array[1]);
            $('#nombre_promotor').html(array[2]);
            $('#compañia').html(array[3]);
            estilo_tablas1(array[1]);
            estilo_tablas();
          }
        });
    });
    $("#form_terminar").submit(function(e){
        var f = $(this);
        var formData = new FormData(document.getElementById("form_terminar"));
        formData.append("dato", "valor");
        var url = "terminar_actividad.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta)
            {
              if (respuesta=="ok") {
                var promotor = $('#id_promotor_modal').val();
                alertify.success("Tarea terminada Correctamente");
                $('#form_terminar')[0].reset();
                $('#form').show();
                $('#form_terminar').hide();
                estilo_tablas1(promotor);
              }else {
                alertify.error("Ha ocurrido un error");
              }
            }
          });
        // Evitar ejecutar el submit del formulario.
        return false;
    });
    function salida_promotor(id_promotor){
      $.ajax({
        type: "POST",
        url: 'salida_promotor.php',
        data: {'id_promotor':id_promotor}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            alertify.success("Salida Registrada");
            estilo_tablas();
          }else if (respuesta == "existe"){
            alertify.error("Ya se Registro Salida");
          }else{
            alertify.error("Ha ocurrido un error");
          }
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
