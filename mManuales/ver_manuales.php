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
          <h3 class="box-title">Lista de Manuales</h3>
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
                      <th width="10%">Ver</th>
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
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-danger" id="contenedor_pdf">
        <div class="box-header">
          <h3 class="box-title">Visor de Manuales</h3>
          <div class="text-right">
            <button id="borrar" class="btn btn-warning" onclick="borrar()">Cerrar</button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <center>
             <div id="my_pdf_viewer">
               <div id="canvas_container">
                  <canvas id="pdf_renderer"></canvas>
                </div>
                <br>  
                <div id="navigation_controls">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4"></div>
                      <div class="col-md-1">
                        <button id="go_previous" class="btn-sm btn-danger">Atras</button>
                      </div>
                      <div class="col-md-1">
                        <input id="current_page" value="1" type="text" readonly class="form-control">
                      </div>
                      <div class="col-md-1">
                        <button id="go_next" class="btn-sm btn-danger">Siguiente</button>
                      </div>
                      <div class="col-md-2">
                        <button id="zoom_in" class="btn-sm btn-danger">+</button>
                        <button id="zoom_out" class="btn-sm btn-danger">-</button>
                      </div>
                      <div class="col-md-4">
                        
                      </div>
                    </div>
                  </div>  
                </div>
                <br>
             </div>
            </center>
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
  function estilo_tablas() {
    $('#lista_manuales').dataTable().fnDestroy();
    $('#lista_manuales').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "lista_manuales.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Descripcion" },
        { "data": "Ver" }
      ]
    });
   }
   estilo_tablas();  
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
  <script type="text/javascript">
    if (localStorage.getItem("pdf")){
      var pdflocal = localStorage.getItem("pdf");
    }
    else{
      var pdflocal = "manuales/visor.pdf";
    }
    var myState = {
        pdf: null,
        currentPage: 1,
        zoom: 1
      }
    pdfjsLib.getDocument(pdflocal).then((pdf) => {
      myState.pdf = pdf;
      render();
    });
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
        var array    = eval(respuesta);
        nombre      = array[0];
        descripcion = array[1];
        ruta        = array[2];

        $('#id_registro').val(id_registro);
        $('#nombre').val(nombre);
        $('#descripcion').val(descripcion);
        $("#imagen_presentacion").attr("src",imagen_p);
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
  </script>
</body>
</html>
