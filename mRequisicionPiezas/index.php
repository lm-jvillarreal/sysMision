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
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <div class="box-header">
            <h3 class="box-title">Requisición de Piezas | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <input type="text" name="id_registro" id="id_registro" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Sucursal:</label>
                    <select name="id_sucursal" id="id_sucursal" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Orden de Trabajo:</label>
                    <input type="text" name="o_trabajo" id="o_trabajo" class="form-control" placeholder="Orden de Trabajo">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Area:</label>
                    <input type="text" name="area" id="area" class="form-control" placeholder="Area">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>*Justificación:</label>
                    <input type="text" name="justificacion" id="justificacion" class="form-control" placeholder="Justificacion">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
            <form method="POST" id="form_datos2" style="display: none;">
              <input type="text" name="folio" id="folio" class="form-control hidden">
              <input type="text" name="id_registro2" id="id_registro2" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Sucursal:</label>
                    <select name="id_sucursal2" id="id_sucursal2" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Parte:</label>
                    <select name="parte" id="parte" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Cantidad:</label>
                    <input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="button" class="btn btn-warning" id="guardar_detalle">Guardar Detalle</button>
                <button type="button" class="btn btn-danger" id="terminar">Terminar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger" id="tabla_principal">
          <div class="box-header">
            <h3 class="box-title">Orden de Compra | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_requisiciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Orden T.</th>
                        <th>Area</th>
                        <th>Justificacion</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger" id="tabla2" style="display: none;">
          <div class="box-header">
            <h3 class="box-title">Orden de Compra | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Pieza</th>
                        <th>Cantidad</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>  
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
 <?php include '../footer2.php'; ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  $('#terminar').click(function(){
    $('#tabla_principal').show();
    $('#form_datos').show();
    $('#form_datos2').hide();
    $('#tabla2').hide();
    $('#form_datos2')[0].reset();
    $('#form_datos')[0].reset();
    $("#id_sucursal").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
    $("#parte").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
  })
  $('#guardar_detalle').click(function(){
    var limite = document.querySelector('#cantidad'); 
    var cantidad = $('#cantidad').val();
    var parte = $('#parte').val();
    // alert(limite.placeholder+' '+cantidad);

    if(cantidad > limite.placeholder){
      alertify.error("Verifica Cantidad");
      return false;
    }
    if(cantidad == 0){
      alertify.error("Verifica Cantidad");
      return false;
    }
    if(parte == null || parte == ""){
      alertify.error("Verifica Campos");
      return false;
    }
    $.ajax({
        type: "POST",
        url: 'guardar2.php',
        data: $("#form_datos2").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta == "ok") {
            alertify.success("Registro guardado correctamente");
            cargar_tabla2();
            $("#parte").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#cantidad').val("");
            $('#cantidad').prop('placeholder','Cantidad');
          }else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
  })
  $('#id_sucursal').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "combo_sucursales.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
      return {
        searchTerm: params.term
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
  $('#id_sucursal2').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "combo_sucursales.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
      return {
        searchTerm: params.term
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
  $('#parte').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "combo_catalogo.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
      return {
        searchTerm: params.term,
        id_sucursal: $('#id_sucursal2').val()
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
  $('#parte').change(function(){
    var id_pieza = this.value;
    var id_sucursal = $('#id_sucursal2').val();
    if(id_pieza == "" || id_pieza == null){
      return false;
    }
    $.ajax({
      url: 'consulta.php',
      data: {'id_pieza':id_pieza, 'id_sucursal':id_sucursal} ,
      type: "POST",
      success: function(respuesta) {
        if(respuesta <= 0){
          $('#cantidad').prop('placeholder',respuesta);
          $('#guardar_detalle').prop('disabled',true);
          alertify.error("No cuentas con Piezas");
        }else{
          $('#guardar_detalle').prop('disabled',false);
          $('#cantidad').prop('placeholder',respuesta);
        }
      }
    });
  })
  function cargar_tabla() {
      $('#lista_requisiciones').dataTable().fnDestroy();
      $('#lista_requisiciones').DataTable( {
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
              title: 'Control Equipos',
              exportOptions: {
              columns: ':visible'
              }
          },
          {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Control Equipos',
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
          "url": "tabla.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Sucursal"},
          { "data": "OrdenT" },
          { "data": "Area"},
          { "data": "Justificacion"},
          { "data": "Editar", "width":"3%"},
          { "data": "Eliminar", "width":"3%"}
        ]
      });
  }
  function cargar_tabla2() {
    var folio = $('#folio').val();
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
              title: 'Control Equipos',
              exportOptions: {
              columns: ':visible'
              }
          },
          {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Control Equipos',
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
          "url": "tabla2.php",
          "dataSrc": "",
          "data":{folio:folio},
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Parte"},
          { "data": "Cantidad","width":"3%" },
          { "data": "Eliminar", "width":"3%"}
        ]
      });
  }
  cargar_tabla();
  $.validator.setDefaults( {
    submitHandler: function () {
      $.ajax({
        type: "POST",
        url: 'guardar.php',
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);
          if (array[0]=="ok" && array[1] != 0) {
            alertify.success("Registro guardado correctamente");
            $('#form_datos')[0].reset();
            $("#id_sucursal").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#folio').val(array[1]);
            cargar_tabla();
            $('#tabla_principal').hide();
            $('#form_datos').hide();
            $('#form_datos2').show();
            $('#tabla2').show();
            cargar_tabla2();
          }else if(array[0]=="ok" && array[1] == 0){
            alertify.success("Registro Actualizado correctamente");
            cargar_tabla();
            $('#form_datos')[0].reset();
            $("#id_sucursal").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
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
        id_sucursal: "required",
        o_trabajo: "required",
        area: "required",
        justificacion: "required"
      },
      messages: {
        id_sucursal: "Campo requerido",
        o_trabajo: "Campo requerido",
        area: "Campo requerido",
        justificacion: "Campo requerido"
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
  function eliminar(id){
    swal({
      title: "¿Está Seguro de Eliminar Registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar.php',
          data: {'id':id} ,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Registro Eliminado');
              cargar_tabla();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
            }
        });
      }
    });
  }
  function editar(id){
    $.ajax({
      url: 'editar.php',
      data: {'id':id},
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        $('#id_registro').val(id);
        $("#id_sucursal").select2("trigger", "select", {
          data: { id: array[0], text:array[1] }
        });
        $('#justificacion').val(array[2]);
        $('#area').val(array[3]);
        $('#o_trabajo').val(array[4]);
      }
    });
  }
  function eliminar_detalle(id){
    swal({
      title: "¿Está Seguro de Eliminar Registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_detalle.php',
          data: {'id':id} ,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Registro Eliminado');
              cargar_tabla2();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
            }
        });
      }
    });
  }
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
