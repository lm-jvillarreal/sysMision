<?php
  include '../global_seguridad/verificar_sesion.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="../d_plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
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
          <h3 class="box-title">Ayuda M&oacute;dulos del Sistema</h3>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nombre_modulo">*Seleccione M&oacute;dulo</label>
                  <select id="modulo" name="modulo" class="select2" style="width: 100%" onchange="cargar(this.value);"></select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nombre_modulo">*Cargar Manual</label>
                  <input type="file" name="manual" id="manual" accept="application/pdf">
                  <br>
                  <center>
                    <a class="btn btn-warning" id="ver_manual" target="_blank" style="display: none">Ver Manual</a>
                  </center>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 text-center">
                <textarea rows="3" class="textarea" name="ayuda" id="ayuda" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                </textarea>
              </div>
            </div>
            <br>
            <label>*Texto Anterior:</label>
            <div id="texto_anterior">
              
            </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Actualizar</button>
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
<script src="../d_plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
  bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script> -->
<!-- <script type="text/javascript" src="<your installation path>/tiny_mce/tiny_mce.js"></script> -->
<script type="text/javascript">
  $('#ayuda').wysihtml5();
  $.validator.setDefaults( {
    submitHandler: function () {
      var f = $(this);
      var formData = new FormData(document.getElementById("form_datos"));
      formData.append("dato", "valor");
      var url = "insertar_ayuda.php"; // El script a dónde se realizará la petición.
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
            alertify.success("Módulo Actualizado Correctamente");
            $("#ayuda").val(''); //Limpiar los campos tipo Text
            $("#manual").val(''); //Limpiar los campos tipo Text
            llenar_combo();

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
          modulo: "required",
          ayuda: "required"
        },
        messages: {
          modulo: "Campo requerido",
          ayuda: "Campo requerido"
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
    function cargar(id_modulo){
      var url = "llenar_modulo.php";
      $.ajax({
       type: "POST",
       url: url,
       data:{'id_modulo': id_modulo}, // Adjuntar los campos del formulario enviado.
       success: function(respuesta)
       {
        var array  = eval(respuesta);
        var texto  = array[0];
        var manual = array[1];
        if(manual == null){
          manual = "";
          $('#ver_manual').hide();
        }
        else{
          $('#ver_manual').show();
        }
        $('#ver_manual').attr('href','../mModulos/'+manual);

        $('#texto_anterior').html(texto);
       }
     });
    }
    $('#modulo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      // minimumResultsForSearch: Infinity,
      ajax: {
        url: "combo_modulos.php",
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
  </script>
</body>
</html>
