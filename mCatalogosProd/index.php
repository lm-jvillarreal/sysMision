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
    <?php include 'menuV.php'; ?>
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
            <h3 class="box-title">Control de Producción | Registro de Catálogos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nombre_catalogo">*Catálogo</label>
                  <input type="text" name="nombre_catalogo" id="nombre_catalogo" class="form-control" placeholder="Ingresa un nombre" required="true">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cantidad_codigos">*Num. Códigos</label>
                  <input type="number" name="cantidad_codigos" id="cantidad_codigos" class="form-control" required="true">
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-crear">Crear</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Producción | Lista de Códigos</h3>
          </div>
          <div class="box-body" id="lista_codigos">
           
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Guardar</button>
          </div>
        </div>
      </form>
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
    $('#btn-crear').click(function() {
      var cant = $("#cantidad_codigos").val();
      var i = 0;
      for(i=1;i<=cant; i++){
        $("#lista_codigos").append(' <div class="row"><div class="col-md-2"><div class="form-group"><input type="text" id ="cantidad'+i+'" name="cantidad[]" class="form-control" onkeydown="datos_producto(this.id)"></div></div><div class="col-md-4"><div class="form-group"><input type="text" name="descripcion[]" class="form-control" id = "descripcion'+i+'"></div></div></div>');
      }
      return false;
    });
  });
  function datos_producto(id_control){
    var ide = "#"+id_control;
    $(ide).keypress(function(e) {
      if(e.which == 13) {
        var url = "consulta_producto.php"; // El script a dónde se realizará la petición.
        var codigo_producto = $(ide).val();
        var numero = id_control.substr(-1);
        var id_descripcion = "#descripcion"+numero;
        //alert(id_descripcion);
        $.ajax({
           type: "POST",
           url: url,
           data: {codigo_producto:codigo_producto}, // Adjuntar los campos del formulario enviado.
           success: function(respuesta)
           {
            var array = eval(respuesta);
            $(id_descripcion).val(array[1]);
           }
         });
        return false;
      }
    });
  };
  $('#btn-guardar').click(function() {
    var url = "insertar_catalogo.php"; // El script a dónde se realizará la petición.
    $.ajax({
       type: "POST",
       url: url,
       data: $('#form-catalogo').serialize(), // Adjuntar los campos del formulario enviado.
       success: function(respuesta)
       {
        if (respuesta=="ok") {
          alertify.success("Catálogo guardado correctamente");
        }else if(respuesta=="repetido"){
          alertify.error("Error al registrar el catálogo");
        }
       }
     });
    return false;
  });
</script>
</body>
</html>
