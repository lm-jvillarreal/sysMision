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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Módulos | Cambiar Clasificación</h3>
          </div>
          <div class="box-body">
          <form action="" method="POST" id="form-datos">
           <div class="row">
             <div class="col-md-4">
               <div class="form-group">
                 <label for="modulo">Módulo</label>
                 <select name="modulo" id="modulo" class="form-control">
                   <option value=""></option>
                 </select>
               </div>
             </div>
             <div class="col-md-4">
               <div class="form-group">
                 <label for="categoria">Categoría</label>
                 <select name="categoria" id="categoria" class="form-control">
                   <option value=""></option>
                 </select>
               </div>
             </div>
           </div>
           </form>
          </div>
           <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Actualizar Categoría</button>
          </div>
          </form>
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
  $('#modulo').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
       url: "consulta_modulos.php",
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
  $('#categoria').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
       url: "consulta_categoria.php",
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
  $("#modulo").change(function(){
    var url = "consulta_cat.php";
    var modulo = $("#modulo").val();
    $.ajax({
       type: "POST",
       url: url,
       data: {modulo:modulo}, // Adjuntar los campos del formulario enviado.
       success: function(respuesta)
       {
        var array = eval(respuesta);
        var id_categoria = array[0];
        var nombre_categoria = array[1];
         $("#categoria").select2("trigger", "select", {
        data: { id: id_categoria, text:nombre_categoria }
      });
        
       }
     });
  });
  $("#btn-guardar").click(function(){
    var url = "actualizar_categoria.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-datos').serialize(),
        success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Categoría actualizada correctamente");
        }
        },
        error: function(xhr, status) {
            alert("error");
            //alert(xhr);
        },
    })
    return false;
  });
</script>
</html>
