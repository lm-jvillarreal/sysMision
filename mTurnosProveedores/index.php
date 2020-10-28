<?php include '../global_seguridad/verificar_sesion.php'; ?>
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
          <form  method="POST" >
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Asignaci&oacute;n de Turnos</h3>
                <br>
                <br>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                      <label>Selecciona un proveedor</label>
                      <select class="form-control" name="proveedor" id="proveedor"></select>
                  </div>	
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Tipo</label>
                    <select class="form-control">
                      <option disabled selected>Seleccione...</option>
                      <option value="1">Local</option>
                      <option value="2">Foraneo</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <a href="#" onclick="registrar();" class="btn btn-danger">Registrar</a>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#pendientes" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Turnos Pendientes
                    </a>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#proceso" aria-expanded="false" aria-controls="collapseExample">
                      Turnos en proceso
                    </button>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#liberados" aria-expanded="false" aria-controls="collapseExample">
                      Turnos liberados
                    </button>
                </p>
              </div>
            </div>
          </form>
    <!-- /.content -->
      <div class="box box-danger">
          <div class="box-header">
              <h3 class="box-title">Lista de Turnos</h3>
          </div>
        <div class="collapse" id="pendientes">
          <div class="card card-body">
            <div class="box-body">
              <div class="row">
                  <div class="col-md-12" id="tabla_pendientes">
                    <?php include 'tabla_turnos_dia.php'; ?>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="collapse" id="proceso">
          <div class="card card-body">
            <div class="box-body">
              <div class="row">
                  <div class="col-md-12" id="tabla_pendientes">
                    <?php include 'tabla_turnos_proceso.php'; ?>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="collapse" id="liberados">
          <div class="card card-body">
            <div class="box-body">
              <div class="row">
                  <div class="col-md-12" id="tabla_pendientes">
                    <?php include 'tabla_turnos_todos.php'; ?>
                  </div>
              </div>
            </div>
          </div>
        </div>        
      </div>
  </div>

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
    function cargar_tabla(){
        var paciente = $("#Paciente").val();
        $('#lista_turnos').dataTable().fnDestroy();
        $('#lista_turnos').DataTable( {
            'language': {"url": "../plugins/DataTables/Spanish.json"},
            "paging":   true,
            "order": [[0,"desc"]],
            "dom": 'Bfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "ajax": {
                "type": "POST",
                "url": "tabla_turnos.php",
                "dataSrc": "",
                "data":""
            },
            "columns": [
                { "data": "id" },
                { "data": "fecha" },
                { "data": "consecutivo" },
                { "data": "imprimir" }
            ]
        });
    }
    cargar_tabla();
    
</script>
    <script>
      function cargar(){
        $.ajax({
          url: 'cargar_registros.php',
          success: function (array){
            var array = eval(array);
            turno         = array[0];
            consecutivo   = array[1];

            $('#turno_actual').html(turno);
            $('#turno_impreso').html(consecutivo);
          }
        })
      }
      cargar();
    </script>
    <script>
       
      function imprimir() {

              var url = "insertar_datos.php";

              window.open(url, "_blank", "width=650,height=400,top=100,left=490,scrollbars=NO,menubar=NO,titlebar= NO,status=NO,toolbar=NO");
              cargar_tabla();
              return false;
          }
    cargar(); 
    </script>
<script>
  $(function () {
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "consulta_proveedores.php",
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
  })
</script>
<script type="text/javascript">
  function registrar() {
    var nombre = $("#proveedor option:selected").html();
    var valor = $('#proveedor').val();
    var tipo = $('#tipo').val();
    $.ajax({
        url: "insertar_turno.php",
        type: "POST",
        dateType: "html",
        data: {
            'nombre':nombre,
            'valor': valor,
            'tipo': tipo
        },
        success: function(respuesta) {
            alert("Turno agregado");
            blanco();
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}
</script>

  </body>
</html>
