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
          <h3 class="box-title">Materiales | Lista de Pedido de Materiales</h3>
        </div>
        <div class="box-body">
          <div class="row">
           <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_solicitudes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Solicita</th>
                      <th>Sucursal</th>
                      <th>Fecha</th>
                      <th>Ver Pedido</th>
                      <th>Surtir P.</th>
                      <th>Surtir</th>
                      <th>Cancelar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Solicita</th>
                      <th>Sucursal</th>
                      <th>Fecha</th>
                      <th>Ver Pedido</th>
                      <th>Surtir P.</th>
                      <th>Surtir</th>
                      <th>Cancelar</th>
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

<?php include '../footer.php'; include 'modal_surtir2.php'?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function cargar_tabla(){
    $('#lista_solicitudes').dataTable().fnDestroy();
    $('#lista_solicitudes').DataTable( {
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
          title: 'Lista Materiales',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          text: 'Exportar a PDF',
          className: 'btn btn-default',
          title: 'Lista Materiales',
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
        "url": "tabla_solicitudes.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#", "width": "5%" },
        { "data": "Nombre" },
        { "data": "Solicita"},
        { "data": "Sucursal", "width": "5%"},
        { "data": "Fecha", "width": "5%" },
        { "data": "VerPedido", "width": "8%" },
        { "data": "SurtirP", "width": "8%" },
        { "data": "Surtir", "width": "5%" },
        { "data": "Cancelar"}
      ]
    });
  }
  $(function (){
   cargar_tabla();
  })
  function ver_pdf(id){
    $.ajax({
      type: "POST",
      url: 'cambiar_estatus.php',
      data: {'id':id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        window.open("pdf.php?id_pedido="+id, '_blank');
      }
    });
  }
  function cancelar(id,numero){
    var comentario = $('#input'+numero).val();
    if(comentario == ""){
      alertify.error("Ingresa un comentario");
      return false; 
    }
    $.ajax({
      type: "POST",
      url: 'cancelar_pedido.php',
      data: {'id':id,'comentario':comentario}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          alertify.success("Pedido Cancelado");
          cargar_tabla();
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
  }
  function surtir(id){
    $.ajax({
      type: "POST",
      url: 'surtir.php',
      data: {'id':id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          alertify.success("Pedido Surtido");
          cargar_tabla();
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
  }
  $('#modal-surtir2').on('show.bs.modal', function(e) {
     var id = $(e.relatedTarget).data().id; 
     cargar_tabla2(id);
  });
  function cargar_tabla2(id){
    $('#lista_surtir').dataTable().fnDestroy();
    $('#lista_surtir').DataTable( {
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
          title: 'Bitacora Servicios',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          text: 'Exportar a PDF',
          className: 'btn btn-default',
          title: 'Bitacora Servicios',
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
        "url": "tabla_editar.php",
        "dataSrc": "",
        "data":{'id':id}
      },
      "columns": [
        { "data": "#", "width": "5%" },
        { "data": "Descripcion" },
        { "data": "Solicitado", "width": "5%"},
        { "data": "Surtir", "width": "5%"}
      ]
    });
  }
  function surtir2(){
    $.ajax({
      type: "POST",
      url: 'surtir2.php',
      data: $('#form_surtir').serialize(), // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          alertify.success("Pedido Surtido");
          $('#modal-surtir2').modal('hide');
          cargar_tabla();
        }else if(respuesta == "verifica"){
          alertify.error("Verifica Cantidades");
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
  }
  </script>
</body>
</html>
