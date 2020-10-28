<?php
  include '../global_seguridad/verificar_sesion.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <style>
    #canvas_container {
      width: 800px;
      height: 450px;
      overflow: auto;
    }
    #canvas_container {
      background: #333;
      text-align: center;
      border: solid 3px;
    }
  </style>
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
        <div class="box box-danger" <?php echo $solo_lectura; ?>>
          <div class="box-header">
            <h3 class="box-title">Registro de Manuales</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" name="id_registro" id="id_registro" value="0" class="hidden">
                    <label for="nombre">*Nombre Manual</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre Manual">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="modelo">*Descripcion</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="categoria">*Categoria</label>
                    <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Categoria">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="numero_serie">*Cargar Manual</label>
                    <input type="file" name="manual" id="manual">
                    <br>
                    <center>
                      <a style="display: none;" target="_blank" id="manual_descargar"><i class="fa fa-download fa-3x" aria-hidden="true"></i></a>
                    </center>
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
            <h3 class="box-title">Lista de Manuales Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_manuales" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Categoria</th>
                        <th width="10%">Editar</th>
                        <th width="10%">Eliminar</th>
                        <th width="10%">Ver</th>
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

<?php include '../footer.php'; ?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
<script>
  function estilo_tablas () {
    $('#lista_manuales').dataTable().fnDestroy();
    $('#lista_manuales').DataTable( {
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
        "url": "tabla_manuales.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Descripcion" },
        { "data": "Categoria" },
        { "data": "Editar" },
        { "data": "Eliminar" },
        { "data": "Ver" }
      ]
    });
   }  
  $(function (){
   estilo_tablas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_manual.php"; // El script a dónde se realizará la petición.
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
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
                alertify.success("Registro guardado correctamente");
                $(':text').val("");
                $('#manual').val("");
                estilo_tablas();
              }else if(respuesta=="duplicado"){
                alertify.error("El registro ya existe");
              }else {
                alertify.error("Ha ocurrido un error");
              }
            }
          });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          nombre: "required",
          descripcion: "required",
          categoria: "required"
        },
        messages: {
          nombre: "Campo requerido",
          descripcion: "Campo requerido",
          categoria: "Campo requerido"
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
  </script>
  <script>
    function render() {
      myState.pdf.getPage(myState.currentPage).then((page) => {
        var canvas = document.getElementById("pdf_renderer");
        var ctx = canvas.getContext('2d');
        var viewport = page.getViewport(myState.zoom);
        canvas.width = viewport.width;
        canvas.height = viewport.height;
        page.render({
          canvasContext: ctx,
          viewport: viewport
        });
      });
    }
  </script>
  <script>
    document.getElementById('go_previous').addEventListener('click', (e) => {
    if(myState.pdf == null|| myState.currentPage == 1) return;
    myState.currentPage -= 1;
    document.getElementById("current_page").value = myState.currentPage;
    render();
    });
    document.getElementById('go_next').addEventListener('click', (e) => {
    if(myState.pdf == null|| myState.currentPage > myState.pdf._pdfInfo.numPages) return;
      myState.currentPage += 1;
      document.getElementById("current_page").value = myState.currentPage;
      render();
    });
    document.getElementById('current_page').addEventListener('keypress', (e) => {
      if(myState.pdf == null) return;
        // Get key code
      var code = (e.keyCode ? e.keyCode : e.which);
      // If key code matches that of the Enter key
      if(code == 13) {
        var desiredPage = document.getElementById('current_page').valueAsNumber;
        if(desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
          myState.currentPage = desiredPage;
          document.getElementById("current_page").value = desiredPage;
          render();
        }
      }
    });
    document.getElementById('zoom_in').addEventListener('click', (e) => {
      if(myState.pdf == null) return;
      myState.zoom += 0.5;
      render();
    });
    document.getElementById('zoom_out').addEventListener('click', (e) => {
      if(myState.pdf == null) return;
      myState.zoom -= 0.5;
      render();
    });
  </script>
  <script>
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
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                estilo_tablas();
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
    function editar_registro(id_registro){
    $.ajax({
      url: 'editar_registro.php',
      data: '&id_registro='+ id_registro,
      type: "POST",
      success: function(respuesta) {
        var array   = eval(respuesta);
        nombre      = array[0];
        descripcion = array[1];
        categoria   = array[2];
        ruta        = array[3];

        $('#manual_descargar').show();
        $('#manual_descargar').attr('href', ruta);
        $('#id_registro').val(id_registro);
        $('#nombre').val(nombre);
        $('#descripcion').val(descripcion);
        $('#categoria').val(categoria);
      }
    });
  }
  function borrar() {
    localStorage.removeItem('pdf');
    location.reload();
  }
  function abrir(ruta) {
    localStorage.setItem("pdf", "manuales/" + ruta + ".pdf");
    location.reload();
  }
  $(":file").filestyle('buttonText', 'Seleccionar');
  $(":file").filestyle('size', 'sm');
  $(":file").filestyle('input', true);
  $(":file").filestyle('disabled', false);
  </script>
</body>
</html>
