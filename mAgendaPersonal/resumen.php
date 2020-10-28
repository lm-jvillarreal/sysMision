<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
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

        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Eventos del Calendario</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_eventos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre Evento</th>
                        <th width="20%">Fecha Inicio</th>
                        <th width="20%">Fecha Final</th>
                        <th width="20%">Invitar</th>
                        <th width="10%">Eliminar</th>
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
                      </tr>
                    </tbody>  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- </div> -->
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function cargar_tabla_eventos(){
    $('#lista_eventos').dataTable().fnDestroy();
    $('#lista_eventos').DataTable( {
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
            title: 'Control Tiempo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Tiempo',
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
          "url": "tabla_eventos.php",
          "dataSrc": ""
      },
      "columns": [
          { "data": "#" },
          { "data": "Nombre Evento" },
          { "data": "Fecha Inicio" },
          { "data": "Fecha Final" },
          { "data": "Invitados" },
          { "data": "Eliminar" },
      ]
   });
  }
  cargar_tabla_eventos();
</script>
<script>
  function act_fecha1(numero){
    if ($('#ifecha1'+numero).hasClass('hidden')){
      $('#ifecha1'+numero).removeClass('hidden');  
    }
    else{
      $('#ifecha1'+numero).addClass('hidden');
    }
  }
  function add_invi(numero){
    var url = "insertar_invitados.php"; // El script a dónde se realizará la petición.
    $.ajax({
      type: "POST",
      url: url,
      data: $("#select"+numero).serialize(), // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta == "ok"){
          cargar_tabla_eventos();
        }
        else{
          alertify.error("Ha ocurrido un error");
        }
      }
    });
  }
  function act_fecha2(numero){
    if ($('#ifecha2'+numero).hasClass('hidden')){
      $('#ifecha2'+numero).removeClass('hidden');  
    }
    else{
      $('#ifecha2'+numero).addClass('hidden');
    }
  }
  function act_nombre(numero){
    if ($('#input_nombre'+numero).hasClass('hidden')){
      $('#input_nombre'+numero).removeClass('hidden');  
    }
    else{
      $('#input_nombre'+numero).addClass('hidden');
    }
  }
  function act_nom(nombre,id){
    $.ajax({
      url: 'actualizar_evento4.php',
      data: '&id='+ id+'&nombre='+ nombre,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Nombre Actualizada');
          cargar_tabla_eventos();
        }
        else if (respuesta == "igual"){
          
        }
        else{
          alert(respuesta);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function act_inv(numero,id){
    $('#sinv'+numero).removeClass('select2');
    if ($('#sinv'+numero).hasClass('hidden')){
      $('#boton'+numero).show();
      $('#sinv'+numero).removeClass('hidden');
      $('#sinv'+numero).addClass('select2');
      $(function () {
        $('.select2').select2({
          placeholder: 'Seleccione una opcion',
          lenguage: 'es'
        })
      });
      select_usuarios(numero,id);  
    }
    else{
      $('#sinv'+numero).addClass('hidden');
    }
  }
  function actualizar1(fecha,id){
    $.ajax({
      url: 'actualizar_evento2.php',
      data: '&id='+ id+'&fecha='+ fecha,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Fecha Actualizada');
          cargar_tabla_eventos();
        }
        else if (respuesta == "mayor"){
          alertify.error('Verifica Fecha');
        }
        else{
          alert(respuesta);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function actualizar2(fecha,id){
    $.ajax({
      url: 'actualizar_evento3.php',
      data: '&id='+ id+'&fecha='+ fecha,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Fecha Actualizada');
          cargar_tabla_eventos();
        }
        else if (respuesta == "menor"){
          alertify.error('Verifica Fecha');
        }
        else{
          alert(respuesta);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
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
          url: 'eliminar_evento.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Evento Eliminado');
              cargar_tabla_eventos();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
          }
        });
      } else {
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
  function select_usuarios(numero,id) {
    $.ajax({
      type: "POST",
      url: "combo_usuarios.php",
      data: '&id='+ id ,
      type: "POST",
      success: function(response)
      { 
        $('#sinv'+numero).html(response).fadeIn();
      }
    });
  }
  function limpiar_agenda(){
    $.ajax({
      url: 'quitar_eventos.php',
      data: {},
      type: "POST",
      success: function(respuesta) {
        alertify.success(respuesta + ' Registros Eliminados');
        location.reload();
      }
    });
  }
</script>
</body>
</html>