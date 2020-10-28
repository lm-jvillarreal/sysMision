<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
  include '../global_settings/conexion_oracle.php';

  // $codigo_producto = "214";

  // $cadena_consulta = "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_producto'";
  // $st = oci_parse($conexion_central, $cadena_consulta);
  // oci_execute($st);
  // $row_producto = oci_fetch_row($st);
  // echo $row_producto[0];
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include '../head.php'; ?>
    <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
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
      <div class="box box-danger" id="contenedor_categoria" <?php echo $solo_lectura; ?>>
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Registro de Categorías</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre">*Categoria</label>
                <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Nombre de Categoria">
                <input type="hidden" name="id_registro" id="id_registro" value="0">
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <button class="btn btn-warning" id="guardarCategoria">Guardar Categoría</button>
        </div>
      </div>
      <div class="box box-danger" id="contenedor_tabla">
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Lista de Categorías</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_categorias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-danger" id="contenedor_detalle" style="display: none;">
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Registro de Códigos</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <input type="hidden" id="id_solicitud">
                <label for="codigo">*Código</label>
                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresa el código de producto"/>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="descripcion">*Descripción</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion del producto" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <button class="btn btn-danger" id="terminar">Terminar</button>
        </div>
      </div>
      <div class="box box-danger" id="contenedor_tabla2" style="display: none;"  onmouseover="efecto();">
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Detalle de Categoría</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <form action="" method="POST" id="form_detalle">
                <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Imagen</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Imagen</th>
                      <th>Eliminar</th>
                    </tr>
                  </tfoot>
                </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
 <?php include '../footer2.php'; include 'modal.php';?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php'; ?>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
<script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>
<!-- Page script -->
<script>
  function cargar_tabla(){
    $('#lista_categorias').dataTable().fnDestroy();
    $('#lista_categorias').DataTable( {
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
            title: 'Efectivos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Efectivos',
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
          "url": "tabla_categorias.php",
          "dataSrc": "",
      },
      "columns": [
        { "data": "#","width":"3%"},
        { "data": "Nombre"},
        { "data": "Editar","width":"3%"},
        { "data": "Eliminar","width":"3%"},
      ]
   });
  }
  function cargar_tabla2(){
    var id_categoria = $('#id_registro').val();

    $('#lista_detalle').dataTable().fnDestroy();
    $('#lista_detalle').DataTable( {
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
            title: 'Efectivos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Efectivos',
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
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {'id_categoria':id_categoria},
      },
      "columns": [
        { "data": "#","width":"3%"},
        { "data": "Codigo","width":"3%"},
        { "data": "Descripcion"},
        { "data": "Imagen","width":"10%"},
        { "data": "Eliminar","width":"3%"},
      ]
   });
  }
  cargar_tabla();
  function consulta_categoria(){
    $.ajax({
      url: 'consulta_categoria.php',
      type: "POST",
      success: function(respuesta)
      {
        $('#id_registro').val(respuesta);
      }
    });
  }
  $('#guardarCategoria').click(function(){
    var categoria   = $('#categoria').val();
    var id_registro = $('#id_registro').val();
    if(categoria == ""){
      alertify.error("Verifica Campos");
      return false;
    }
    $.ajax({
      url: 'guardar_categoria.php',
      type: "POST",
      data: {'categoria':categoria, 'id_registro':id_registro}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta=="ok") {
          alertify.success("Categoria guardada correctamente");
          consulta_categoria(); //Cargamos el id

          $('#contenedor_categoria').hide(); //Registro Categorias
          $('#contenedor_tabla').hide(); //Tabla Categorias

          $('#contenedor_detalle').show(); //Registro Detalle
          $('#contenedor_tabla2').show(); //Tabla Detalle

          cargar_tabla();
        }else if(respuesta=="duplicado"){
          alertify.error("La Categoria Ya Existe");
        }else {
          alertify.error("Ha ocurrido un error");
        }
      }
    });
  })
  function editar_categoria(id){
    $.ajax({
      url: 'editar_categoria.php',
      type: "POST",
      data: {'id':id}, // Adjuntar los campos del formulario enviado. 
      success: function(respuesta)
      {
        var array = eval(respuesta);

        $('#id_registro').val(array[0]);
        $('#categoria').val(array[1]);
        cargar_tabla2();

        $('#contenedor_tabla').hide(); //Tabla Categorias
        $('#contenedor_detalle').show(); //Registro Detalle
        $('#contenedor_tabla2').show(); //Tabla Detalle
      }
    });
  }
  function eliminar_categoria(id) {
    swal({
      title: "¿Está seguro de eliminar categoria?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_categoria.php',
          data: {'id':id},
          type: "POST",
          success: function(respuesta) {
            if (respuesta = "ok"){
              alertify.success("Registro Eliminado Correctamente");
              cargar_tabla();
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      } 
    });
  }
  function consultar_codigo(){
    var codigo = $('#codigo').val();
    if(codigo == ""){
      alertify.error("Verifica Campos");
      return false;
    }
    $.ajax({
      url: 'consultar_codigo.php',
      data: {'codigo':codigo},
      type: "POST",
      success: function(respuesta) {
        $('#descripcion').val(respuesta);
        insertar_detalle();
      }
    });
  }
  $("#codigo").keypress(function(e) {
    //no recuerdo la fuente pero lo recomiendan para
    //mayor compatibilidad entre navegadores.
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13){
      consultar_codigo();
    }
  });
  function insertar_detalle(){
    var codigo      = $('#codigo').val();
    var id_registro = $('#id_registro').val();
    $.ajax({
      url: 'guardar_detalle.php',
      data: {'codigo':codigo, 'id_registro':id_registro},
      type: "POST",
      success: function(respuesta) {
        if (respuesta = "ok"){
          alertify.success("Registro Guardado Correctamente");
          cargar_tabla2();
          $('#codigo').val('');
        }else if(respuesta = "duplicado"){
          alertify.error("El codigo ya Existe");
        }else{
          alertify.error("Ha Ocurrido un Error");
        }        
      }
    });
  }
  $('#terminar').click(function(){
    $('#categoria').val("");
    $('#id_registro').val("0");
    $('#codigo').val("");
    $('#descripcion').val("");
    cargar_tabla();
    cargar_tabla2();

    $('#contenedor_categoria').show(); //Registro Categorias
    $('#contenedor_tabla').show(); //Tabla Categorias

    $('#contenedor_detalle').hide(); //Registro Detalle
    $('#contenedor_tabla2').hide(); //Tabla Detalle
  })
  function eliminar_detalle(id) {
    swal({
      title: "¿Está seguro de eliminar categoria?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_detalle.php',
          data: {'id':id},
          type: "POST",
          success: function(respuesta) {
            if (respuesta = "ok"){
              alertify.success("Registro Eliminado Correctamente");
              cargar_tabla2();
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      } 
    });
  }
  function abrirModalSubir(id){
    $('#id_codigo').val(id);
    $("#modalSubir").modal("show");
  }
  $("#image").fileinput({
    theme: 'fa',
    language: 'es',
    showUpload: false,
    showCaption: true,
    showCancel: false,
    showRemove: true,
    browseClass: "btn btn-danger",
    fileType: "png",
    allowedFileExtensions: ['png'],
    overwriteInitial: false,
    maxFileSize: 1000,
    maxFilesNum: 1
  });
  $(document).ready(function() {
    $(".upload").on('click', function() {
      var formData  = new FormData();
      var files     = $('#image')[0].files[0];
      var id_codigo =$('#id_codigo').val();
      formData.append('file',files);
      formData.append('id_codigo',id_codigo);
      $.ajax({
        url: 'upload.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response != 0) {
            cargar_tabla2();
            $(".card-img-top").attr("src", response);
            $('#image').fileinput('reset').trigger('custom-event');
            alertify.success('La imagen ha sido cargada con exito.');
            $("#modalSubir").modal("hide");
          }else{
            alertify.error('Formato de imagen incorrecto.');
          }
        },
        error:function(xhr,status){
          alertify.error('Error en proceso');
        },
      });
      return false;
    });
  });
  function efecto(){
    var test = $('.venobox').venobox();
    // close current item clicking on .closeme
    $(document).on('click', '.closeme', function(e){
        test.VBclose();
    });
    // go to next item in gallery clicking on .next
    $(document).on('click', '.next', function(e){
        test.VBnext();
    });
    // go to previous item in gallery clicking on .previous
    $(document).on('click', '.previous', function(e){
        test.VBprev();
    });
  }
</script>
</body>
</html>
