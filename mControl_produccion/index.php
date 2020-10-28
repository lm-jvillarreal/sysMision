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
    <?php include 'menuV3.php'; ?>
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
            <h3 class="box-title">Control de Producción | Registro de Merma</h3>
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
            <form action="" method="POST" id="form-merma">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%">Cve. producto</th>
                        <th>Descripción</th>
                        <th width="10%">Inv. Inicial</th>
                        <th width="10%">Cant. Merma</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Cve. producto</th>
                        <th>Descripción</th>
                        <th>Inv. Inicial</th>
                        <th>Cant. Merma</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-mermar" disabled="disabled">Guardar merma</button>
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
<!-- Page script -->
<script>
  $(document).ready(function() {
      cargar_tabla();
  });
  function cargar_tabla(){
    num_catalogo = $("#catalogo").val();
    $('#lista_codigos').dataTable().fnDestroy();
    $('#lista_codigos').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "ajax": {
            "type": "POST",
            "url": "tabla.php",
            "dataSrc": "",
            "data":{num_catalogo: num_catalogo}
        },
        "columns": [
            { "data": "id" },
            { "data": "cve_producto" },
            { "data": "desc_producto" },
            { "data": "inv_inicial" },
            { "data": "cant_merma" }
        ]
    });
  }
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
  $("#btn-mermar").removeAttr("disabled");
  cargar_tabla();
  return false;
 });
 $("#btn-mermar").click(function(){
    var url = "insertar_merma.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-merma').serialize(),
        success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Merma registrada correctamente");
        }else if(respuesta=="repetido"){
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
   });
</script>
</body>
</html>