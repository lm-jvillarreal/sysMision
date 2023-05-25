<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha      = date('Y-m-d');
  $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
  $hora       = date('h:i:s');
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
            <h3 class="box-title">Autorización de Tiempo Extra</h3>
          </div>
          <div class="box-body">
            <div class="row">
             <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_extras" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th> #</th>
                        <th>Empleado</th>
                        <th>Departamento</th>
                        <th>Sucursal</th>
                        <th>Motivo</th>
                        <th>Tiempo</th>
                        <th>Fecha</th>
                        <th>Autorizar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th> #</th>
                        <th>Empleado</th>
                        <th>Departamento</th>
                        <th>Sucursal</th>
                        <th>Motivo</th>
                        <th>Tiempo</th>
                        <th>Fecha</th>
                        <th>Autorizar</th>
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
  </div>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
  $('#h_pagar').inputmask('99:99');
  function cargar_tabla(){
      $('#lista_extras').dataTable().fnDestroy();
      $('#lista_extras').DataTable( {
          'language': {"url": "../plugins/DataTables/Spanish.json"},
          "paging":   false,
          "order": ["0", "ASC"],
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
              "url": "tabla_tiempo2.php",
              "dataSrc": ""
          },
          "columns": [
              { "data": "id" },
              { "data": "nombre" },
              { "data": "departamento" },
              { "data": "sucursal" },
              { "data": "motivo" },
              { "data": "tiempo" },
              { "data": "fecha" },
              { "data": "activo"}
          ]
      });
    }
      $(function (){
   cargar_tabla();
  }) 
     function autorizar(id, folio, numero){
      var tiempo_aut  = $('#'+id).val();
      var tiempo_disp = $('#tiempo'+numero).val();
      var url="autorizar.php";
      if(tiempo_aut > tiempo_disp){
          alertify.error("Verifica horas a Autorizar"); 
        }
        else{
          $.ajax({
            type:"POST",
            url: url,
            data:{id:id, tiempo_aut:tiempo_aut},
            success: function(respuesta){
              if (respuesta=="ok") {
              alertify.success("Tiempo Extra Autorizado");
              }else{
              alertify.error("Ha Ocurrido un Error");
              }
            }
          })
        }
      // alert(tiempo_aut);
      // alert(tiempo_disp);
    }
</script>
</body>
</html>
