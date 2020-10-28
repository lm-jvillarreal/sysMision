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
            <h3 class="box-title">Registro de Firmas Autorizadas</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
            <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_persona">*Nombre:</label>
                    <input type="hidden" name="id_registro" id="id_registro">
                    <select name="id_persona" id="id_persona" class="select2" style="width: 260px" onchange="llenar()">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="departamento">*Departamento</label>
                  <input type="text" name="departamento" id="departamento" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal</label>
                  <input type="text" name="sucursal" id="sucursal" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="puesto">*Puesto</label>
                  <input type="text" name="puesto"
                   id="puesto" class="form-control" > 
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="permisos">*Permisos</label>
                  <select id="permisos" name="permisos[]" multiple class="select" style="width:100%">
                  </select>
                </div>
              </div>
               <div class="col-md-3">
                  <div class="form-group">
                    <label for="imagen_firma">*Cargar Firma</label>
                    <input name="action" type="hidden" value="upload" id="action" />
                  <input type="file" name="archivos" id="archivos">
                    <br>
                    <center>
                      <a style="display: none;" target="_blank" id="archivos"><i class="fa fa-download fa-3x" aria-hidden="true"></i></a>
                    </center>
                  </div>
                </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Firmas Autorizadas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id= "lista_firmas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre </th>
                        <th width="15%">Puesto</th>
                        <th width="15%">Permisos</th>
                        <th width="10%">Firma</th>
                        <th width="5%">Activo</th>
                         <th width="5%">Eliminar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Permisos</th>
                        <th>Firma</th>
                        <th>Activo</th>
                        <th>Eliminar</th>
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
  <!-- /.content-wrapper -->
  <?php include 'modal_firmas.php'; ?>
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
  })
  $.validator.setDefaults( {
    submitHandler: function () {
      var parametros = new FormData($("#form_datos")[0]);
      $.ajax({
      data: parametros, //datos que se envian a traves de ajax
      url: 'insertar_firma.php', //archivo que recibe la peticion
      type: 'POST', //método de envio
      dateType: 'html',
      contentType: false,
      processData: false,
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            cargar_tabla();
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
  $(function() {
      $('#id_persona').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "http://200.1.1.197/SMPruebas/mTiempoExtra/select_persona.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      })
    });
  $( document ).ready( function () {
    $( "#form_datos" ).validate( {
      rules: {
        id_persona: "required",
        departamento: "required",
        sucursal: "required",
        puesto: "required",
        permisos: "required",
        archivos: "required"
      },
      messages: {
        id_persona: "Campo requerido",
        departamento: "Campo requerido",
        sucursal: "Campo requerido",
        puesto: "Campo requerido",
        permisos: "Campo requerido",
        archivos: "Campo requerido"
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
        $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
      }
    });
  });
  function llenar() {
      var id_persona = $('#id_persona').val();
      var id_registro = $('#id_registro').val();
      if (id_persona != "") {
        var url = 'http://200.1.1.197/SMPruebas/mTiempoExtra/llenar.php';
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            'id_persona': id_persona
          },
          success: function(respuesta) {
            //evaluar el array y separarlo para imprimir por campos
            var array = eval(respuesta)
            $('#departamento').val(array[1]);
            $('#sucursal').val(array[0]);
          },
          error: function(xhr, status) {
            alert("error");
            alert(xhr);
          },
        });
      }
    }

  function estatus(registro){
    var id_registro = registro;
    var url = 'cambiar_estatus.php';
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: {id_registro: id_registro},
      success: function(respuesta) {
        if (respuesta=="ok") {
          alertify.success("Permiso modificado correctamente");
        }
      },
      error: function(xhr, status) {
          alert("error");
          //alert(xhr);
      },
    });
  }
  function eliminar(registro){
    var id = registro;
    var url = 'eliminar_firma.php';
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: {id: id},
      success: function(respuesta) {
        if (respuesta=="ok") {
          alertify.success("Registro eliminado correctamente");
          cargar_tabla();
        }
      },
      error: function(xhr, status){
        alert("error");
      },
    });
  }
  $(function () {
    $('.select').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
  function llenar_combo_permisos() {
    $.ajax({
      type: "POST",
      url: "combo_permisos.php",
      success: function(response)
      { 
        $('#permisos').html(response).fadeIn();
      }
    });
  }
  llenar_combo_permisos();
  
  function cargar_tabla(){
    $('#lista_firmas').dataTable().fnDestroy();
    $('#lista_firmas').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "ajax": {
            "type": "POST",
            "url": "http://200.1.1.197/SMPruebas/mFirmas/tabla_firmas.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "puesto" },
            { "data": "permisos" },
            { "data": "firma" },
            { "data": "activo" },
            { "data": "eliminar" }
        ]
    });
  }
  $('#modal-default').on('show.bs.modal', function(e) {
       var id = $(e.relatedTarget).data().id;
       var url = "http://200.1.1.197/SMPruebas/mFirmas/consulta_datos_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {id:id}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            var array = eval(respuesta);
            
            $('#nom_persona').html(array[0]);
            $("#imagen_persona").attr("src", "firmas/"+id+".jpg");
          }
        });
    });
  </script>
</body>
</html>
