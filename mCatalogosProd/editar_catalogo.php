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
    <?php include 'menuV6.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <form action="" method="POST" id="form-catalogo">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Producción | Editar Catálogo</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nombre_catalogo">*Catálogo</label>
                  <select name="catalogo" id="catalogo" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-cargar">Cargar</button>
          </div>
        </div>
      </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Producción | Lista de Códigos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="text-right">
                  <button class="btn btn-md btn-success" id="btn-sumar" data-toggle="modal" data-target="#modal_editar" disabled>Agregar Código</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%">Cve. producto</th>
                        <th>Descripción</th>
                        <th width="10%">Remover</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Cve. producto</th>
                        <th>Descripción</th>
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
  <?php include 'modal_agregar.php'; ?>
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
  $(document).ready(function() {
    $('#producto').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "consulta_producto.php",
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
    });
      cargar_tabla();
  });
  $("#btn-insertCodigo").click(function(){
      var url = "actualizar_catalogo.php";
      var codigo_prod = $("#codigo_prod").val();
      var desc_prod = $("#desc_prod").val();
      var catalogo = $("#catalogo").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {codigo_prod: codigo_prod, desc_prod: desc_prod, catalogo: catalogo},
        success: function(respuesta) {
          $('#modal_editar').modal('hide');
          $("#codigo_prod").val('');
          $("#desc_prod").val('');
        },
        error: function(xhr, status) {
            alert("error");
            $('#modal_editar').modal('hide');
            $("#codigo_prod").val('');
          $("#desc_prod").val('');
        },
      })
      cargar_tabla();
      return false;
  });
  function datos_producto(){
    $("#codigo_prod").keypress(function(e) {
      if(e.which == 13) {
        var url = "consulta_producto.php"; // El script a dónde se realizará la petición.
        var codigo_producto = $("#codigo_prod").val();
        //alert(id_descripcion);
        $.ajax({
           type: "POST",
           url: url,
           data: {codigo_producto:codigo_producto}, // Adjuntar los campos del formulario enviado.
           success: function(respuesta)
           {
            var array = eval(respuesta);
            $("#desc_prod").val(array[1]);
           }
         });
        return false;
      }
    });
  };
  function cargar_tabla(){
    num_catalogo = $("#catalogo").val();
    $('#lista_codigos').dataTable().fnDestroy();
    $('#lista_codigos').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],
        "ajax": {
            "type": "POST",
            "url": "tabla_editar.php",
            "dataSrc": "",
            "data":{num_catalogo: num_catalogo}
        },
        "columns": [
            { "data": "id" },
            { "data": "cve_producto" },
            { "data": "desc_producto" },
            { "data": "remover" }
        ]
    });
  }
  function eliminar_articulo(id_registro){
    var url = "eliminar_registro.php";
    var cve_catalogo = $("#catalogo").val();
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: {id_registro: id_registro, cve_catalogo: cve_catalogo},
      success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Catálogo actualizado correctamente");
        }else{
          alertify.error("Existió un error");
        }
      },
      error: function(xhr, status) {
          alert("error");
          //alert(xhr);
      },
    });
    cargar_tabla();
    $(":text").val('');
    return false;
  };
 $('#catalogo').select2({
  placeholder: 'Seleccione una opcion',
  lenguage: 'es',
  //minimumResultsForSearch: Infinity
  ajax: { 
   url: "consulta_catalogo.php",
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
});
 $('#btn-cargar').click(function() {
  $("#btn-sumar").removeAttr("disabled");
  cargar_tabla();
  return false;
 });
 $("#btn-sumar").click(function(){
    
 });
</script>
</body>
</html>