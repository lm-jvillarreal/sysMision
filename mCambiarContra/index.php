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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Actualizar Contrase&ntilde;a</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nueva_contra">*Contrase&ntilde;a</label>
                  <input type="password" name="nueva_contra" id="nueva_contra" class="form-control" placeholder="Nueva Contraseña">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="confirmar_contra">*Verificar Contraseña</label>
                  <input type="password" name="confirmar_contra" id="confirmar_contra" class="form-control" placeholder="Confirmar Contraseña" onkeyup ="javascript:validar($('#nueva_contra').val(), $(this).val());">
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-guardar" disabled="true">Guardar</button>
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
  $(function(){
   $("#btn-guardar").click(function(){
   var url = "actualizar_pass.php"; // El script a dónde se realizará la petición.
      $.ajax({
             type: "POST",
             url: url,
             data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
             success: function(data)
             {
                $(":password").val(''); //Limpiar los campos tipo Text
                document.getElementById('confirmar_contra').style.background = '#FFFFFF';
                $("#btn-guardar").prop("disabled",true);
                alertify.success("Contraseña actualizada correctamente"); // Mostrar la respuestas del script PHP.

             }
           });

      return false; // Evitar ejecutar el submit del formulario.
   });
  });
</script>
<script>
	function validar(pass, pass_conf) {
	    if (pass_conf == pass) {
	        document.getElementById('confirmar_contra').style.background = '#2ecc71';
	        $("#btn-guardar").removeAttr("disabled");
	    }
	    else{
	    	document.getElementById('confirmar_contra').style.background = '#e74c3c';
	    	$("#btn-guardar").prop("disabled",true);
	    }
	}
</script>
</body>
</html>
