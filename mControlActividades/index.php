<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css" />
  <!--Select2-->
  <link rel="stylesheet" href="../d_plantilla/bower_components/select2/dist/css/select2.min.css">
  <!--dateTimePicker-->
  <link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
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
            <h3 class="box-title">Listado de Actividades | Control</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table cellspacing="5" cellpadding="5">
                    <tbody>
                      <tr>
                        <td>De:</td>
                        <td>
                        <div class="form-group">
                            <div class='input-group date' id='min'>
                              <input type='text' class="form-control" id='mintxt' />
                              <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                            </div>
                        </div></td>
                      </tr>
                      <tr>
                        <td>A:</td>
                        <td>
                        <div class="form-group">
                            <div class='input-group date' id='max'>
                              <input type='text' class="form-control" id='maxtxt' />
                              <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                            </div>
                        </div>
                      </tr>
                    </tbody>
                  </table>
                  <table id="tabla_referencias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>ID</th>
                        <th width='10%'>Área</th>
                        <th width='15%'>Actividad</th>
                        <th widht="10%">Responsable(s)</th>
                        <th style="width: 30%">Descripción</th>
                        <th width='5%'>Estatus</th>
                        <th width='10%'>Sucursal</th>
                        <th>Fecha alta</th>
                        <th>Fecha término</th>
                        <th>Evidencia</th>
                        <th while='1%'>Src</th>
                        <th width='9%'>Acciones</th>
                      </tr>
                      <tr id="forFilters">
                      <th></th>
                      <th></th>
                      <th></th>
                      <th widht="10%"></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      </tr>
                    </thead>
                    <!--tfoot><tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr></tfoot-->
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
    <?php include 'modal_tickets.php';?>
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
  <!--Date time para seleccionar los controladores de fecha-->
  <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <!--select2-->
  <script src="../d_plantilla/bower_components/select2/dist/js/select2.full.min.js"></script>
  <!--timepicker-->
  <script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-database.js"></script>
  <!-- Page script -->
  <script type="text/javascript">
    var primaryColIdx;
    var secondaryColIdx;
    
    var minFecha,maxFecha;
    var minFecha1,maxFecha1;
    
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex){
          var min = minFecha.val();
          var max = maxFecha.val();
          var date = new Date(data[7]);

          if ((min === null && max === null) 
          || (min === null && date <= max) 
          || (min <= date && max === null) 
          || (min <= date && date <= max)) {
            return true;
          }
          return false;
      });

      
    $(document).ready(function() {
      var column;
      const config = {
        //AQUÍ VA TU PORPIO SDK DE FIREBASE
        apiKey: "AIzaSyCFW7HiqEHwdusfSLx8Na32BfJ0XvkDavA",
        authDomain: "lmmovil-5228f.firebaseapp.com",
        databaseURL: "https://lmmovil-5228f-default-rtdb.firebaseio.com",
        projectId: "lmmovil-5228f",
        storageBucket: "lmmovil-5228f.appspot.com",
        messagingSenderId: "757873465572",
        appId: "1:757873465572:web:4da58f32288fbf361674f1",
        measurementId: "G-E7JNEBYW9W"
      };
      firebase.initializeApp(config); //inicializamos firebase

      var filaEliminada; //para capturara la fila eliminada
      var filaEditada; //para capturara la fila editada o actualizada

      //creamos constantes para los iconos editar y borrar    
      const iconoEditar = '<svg class="bi bi-pencil-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>';
      const iconoBorrar = '<svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>';
      const iconoPdf = '<svg class="bi bi-file-pdf" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>';
      
      var db = firebase.database();
      var coleccionProductos = db.ref().child("Actividades");

      var dataSet = []; //array para guardar los valores de los campos inputs del form
      var table = $('#tabla_referencias').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": [[7,"desc"]],
        buttons: [{
            extend: 'pageLength',
            text: 'Actividades',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Actividades a documentar',
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
        orderCellsTop: true,
        data: dataSet,
        columnDefs: [{
            targets: [0],
            visible: false,                   
          },
          {
            targets:[10],
            visible: false,
          },
          {
            targets: -1,
            defaultContent: "<button class='btnBorrar btn btn-danger' data-toggle='tooltip' title='Borrar'>" + iconoBorrar + "</button>"
          }
        ],
        drawCallback : function(){
          this.api().columns([1,2,3,5,6]).every( function () {
                var column = this;
                var select = $('<select style="width: 120px"class="dt_select2"><option value=""></option></select>')
                    .appendTo( $('thead tr:eq(1) th:eq(' + (this.index() -1) + ')').empty())
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                  column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' );
                  var currSearch = column.search();
                  if ( currSearch ) {
                    select.val( currSearch.substring(1, currSearch.length-1) );
                  }
                } );
            } );
            $('.dt_select2').select2();
        }
      });

      function redireccionar(link) {
        window.open(link, '_blank');
      }
      var fecha = new Date();
      console.log(fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + '01' + ' 00:00');
      console.log(fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + fecha.getDate() + ' 00:00');
      coleccionProductos
      .orderByChild('fechaAlta')
      .startAt('2022-08-01 00:00')
      //.endAt('2022-8-13 00:00')
      .on("child_added", datos => {
        let valor = "";
        if (datos.child("responsable").val() != null) {
          valor = ""+datos.child("responsable").val();
        }else{
          valor = "" + (datos.child("nombre_responsable").val() != "" ? datos.child("nombre_responsable").val() : datos.child("nombre_usuario").val());
        }
        if(datos.child("status").val() == "pendiente"){
          valor = "";
        }
        dataSet = [datos.key, datos.child("area").val(), datos.child("tipo_actividad").val(), valor, datos.child("descripcion").val(), datos.child("status").val(), datos.child("sucursal").val(), datos.child("fechaAlta").val(), datos.child("fechatermino").val(), (datos.child("PdfFirmado").val() === null || datos.child("PdfFirmado").val()=== "") ? "<button class='btn btn-secondary' data-toggle='tooltip' title='Editar'>" + iconoPdf + "</button>" : "<button class='btnPdf btn btn-primary' data-toggle='tooltip' title='Editar'>" + iconoPdf + "</button>", datos.child("PdfFirmado").val()];
        table.rows.add([dataSet]).draw();
        //alertify.success("Nuevo registro");
      });
      coleccionProductos.on('child_changed', datos => {
        dataSet = [datos.key, datos.child("area").val(), datos.child("tipo_actividad").val(), valor, datos.child("descripcion").val(), datos.child("status").val(), datos.child("sucursal").val()];
        table.row(filaEditada).data(dataSet).draw();
      });
      coleccionProductos.on("child_removed", function() {
        table.row(filaEliminada.parents('tr')).remove().draw();
      });
      $("#tabla_referencias").on("click", ".btnBorrar", function() {
        filaEliminada = $(this);
        Swal.fire({
          title: '¿Está seguro de eliminar la actividad?',
          text: "¡Está operación no se puede revertir!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Borrar'
        }).then((result) => {
          if (result.value) {
            let fila = $('#tabla_referencias').dataTable().fnGetData($(this).closest('tr'));
            let id = fila[0];
            db.ref(`Actividades/${id}`).remove()
            Swal.fire('¡Eliminado!', 'La actividad ha sido eliminada.', 'success')
          }
        })
      });
      $("#tabla_referencias").on("click", ".btnPdf", function() {
          let fila = $('#tabla_referencias').dataTable().fnGetData($(this).closest('tr'));
          let id = fila[10];
          window.open(id, '_blank');
          //console.log(id);
      });
      setTimeout(
        function() {
          var fecha = new Date();
          $('#min').val(fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + '01');
          $('#mintxt').val(fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + '01');
          $('#max').val(fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + fecha.getDate()).trigger("change");
          $('#maxtxt').val(fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + fecha.getDate()).trigger("change");
        }, 1500);
      minFecha = new DateTime($('#min'),{
        format: 'YYYY-MM-DD'
      });
      maxFecha = new DateTime($('#max'), {
        format: 'YYYY-MM-DD'
      });

      $('#min').on('change', function(){
        filterDataRange($('#min').val(), $('#max').val());
        $('#mintxt').val($('#min').val());
        table.draw();
      });
      $('#max').on('change', function(){
        filterDataRange($('#min').val(), $('#max').val());
        $('#maxtxt').val($('#max').val());
        table.draw();
      });

      function filterDataRange(from, to){
        $.fn.dataTable.ext.search.pop();

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex){
          var dateStart = moment(from, "YYYY/MM/DD");
          var dateEnd = moment(to, "YYYY/MM/DD");
          var date = new Date(data[7]);

          if((dateStart == null && dateEnd == null)
          || (dateStart == null && date <= dateEnd)
          || (dateStart <=date && max == null)
          || (dateStart <= date && date <= dateEnd)){
            return true;
          }
          return false;

        });
      }
      $('#datetimepicker1').datetimepicker();
    }); 
  </script>
</body>

</html>