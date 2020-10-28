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
    <?php include 'menuV5.php'; ?>
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
            <h3 class="box-title">Control de Producción | Solicitud de Producción</h3>
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
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
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
              <div class="col-md-12 col-lg-12">
                <div class="table-responsive" >
                  <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th width="10%">Cve. producto</th>
                        <th width="35%">Descripción</th>
                        <th width="10%">Inv. Inicial</th>
                        <th width="10%">Cant. Merma</th>
                        <th width="10%">Cant. Ventas</th>
                        <th width="10%">Cant. Restante</th>
                        <th width="10%">Pedido</th>
                        <th width="10%">Observaciones</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Cve. producto</th>
                        <th>Descripción</th>
                        <th>Inv. Inicial</th>
                        <th>Cant. Merma</th>
                        <th>Cant. Ventas</th>
                        <th>Cant. Restante</th>
                        <th>Pedido</th>
                        <th>Observaciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-pedido" disabled="disabled">Guardar pedido</button>
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
    fecha_inicial = $("#fecha_inicial").val();
    fecha_final = $("#fecha_final").val();
    $('#lista_codigos').dataTable().fnDestroy();
    $('#lista_codigos').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "ajax": {
            "type": "POST",
            "url": "tabla_pedido.php",
            "dataSrc": "",
            "data":{num_catalogo: num_catalogo, fecha_inicial: fecha_inicial, fecha_final: fecha_final}
        },
        "columns": [
            { "data": "id" },
            { "data": "cve_producto" },
            { "data": "desc_producto" },
            { "data": "inv_inicial" },
            { "data": "cant_merma" },
            { "data": "cant_ventas" },
            { "data": "cant_restante" },
            { "data": "cant_pedido" },
            { "data": "observaciones" }
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
  $("#btn-pedido").removeAttr("disabled");
  cargar_tabla();
  return false;
 });
 $("#btn-pedido").click(function(){
    var url = "insertar_pedido.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-merma').serialize(),
        success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Pedido registrado correctamente");
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
 $('.form_datetime').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
});
$('.form_date').datetimepicker({
    language:  'es',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
});
$('.form_time').datetimepicker({
    language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
});
</script>
</body>
</html>