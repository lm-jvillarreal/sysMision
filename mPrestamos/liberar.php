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
        <div class="box box-danger" id="tabla_principal">
          <div class="box-header">
            <h3 class="box-title">Prestamos | Liberar</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_prestamos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Persona</th>
                        <th>Sucursal</th>
                        <th>Pieza</th>
                        <th>Cantidad</th>
                        <th>Fecha Devolucion</th>
                        <th>Liberar</th>
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
<!-- Page script -->
<script>
  function cargar_tabla() {
      $('#lista_prestamos').dataTable().fnDestroy();
      $('#lista_prestamos').DataTable( {
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
          "url": "tabla3.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Persona"},
          { "data": "Sucursal" },
          { "data": "Pieza"},
          { "data": "Cantidad", "width":"3%"},
          { "data": "Fecha", "width":"3%"},
          { "data": "Liberar"}
        ]
      });
  }
  cargar_tabla();
  function liberar(id,numero){
    var cantidad = $('#cant_'+numero).val();
    var limite = $('#limite_'+numero).val();
    if(cantidad == 0 || cantidad == ""){
        alertify.error('Verifica Campos');
        return false; 
    }
    if(cantidad > limite){
        alertify.error('Verifica Cantidad');
        return false; 
    }
    swal({
      title: "¿Desea Liberar Esta Pieza?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'liberar_pieza.php',
          data: {'id':id, 'cantidad':cantidad} ,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Pieza Liberada');
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
</script>
</body>
</html>
