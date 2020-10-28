<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <!-- <link rel="stylesheet" href="../mJuntas/estilos.css"> -->
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
          <h3 class="box-title">Usar Materiales</h3>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="material">*Materiales</label>
                    <select id="material" class="form-control" name="material" onchange="llenar(this.value);">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="existente">*Cantidad Existente</label>
                    <br>
                    <center>
                      <label id="existencia"></label>
                    </center>
                    <input type="text" id="cantidad_existencia" name="cantidad_existencia" class="hidden">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cantidad">*Cantidad a Usar</label>
                    <input type="text" name="cantidad" id="cantidad" class="form-control" value="1" onchange="verificar(this.value);" disabled>
                  </div>
                </div>
              </div>                
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar" disabled>Guardar</button>
              </div>
            </form>
        </div>
      </div>
      <!-- </div> -->
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
<script type="text/javascript">
  $(function () {
    $('#material').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "combo_materiales.php",
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
  });
  function llenar(id_material){
    $('#cantidad').attr('disabled', false);
    $('#guardar').attr('disabled', false);
    $.ajax({
      type: "POST",
      url: 'data.php',
      data: {'id_material':id_material}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta != "0"){
          $('#existencia').html(respuesta);
          $('#cantidad_existencia').val(respuesta);
        }
      }
    });
  }
  function verificar(cantidad){
    var limite = $('#cantidad_existencia').val();
    if (cantidad < limite){
      $('#guardar').attr('disabled', false);
    }
    else if(cantidad == limite){
      $('#cantidad').attr('max', limite);
      $('#guardar').attr('disabled', false);
    }
    else{
      alertify.error("No hay suficientes piezas");
      $('#guardar').attr('disabled', true);
      $('#cantidad').attr('max', limite);
    }
  }
  $(function(){
    $("#guardar").click(function(){
      var url = "usar_materiales.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            if(respuesta == "ok"){
              alertify.success("Se ha descontado de existencia correctamente");
            else if(respuesta == "1"){
              alertify.error("Verifica la cantidad a usar");
            }else{
              alertify.error("Ha ocurrido un error");
            }
          }
        });
        return false;
    });
  });
</script>
</body>
</html>