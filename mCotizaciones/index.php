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
      <style>
        .slider {
          -webkit-appearance: none;
          width: 100%;
          height: 15px;
          border-radius: 5px;  
          background: #d3d3d3;
          outline: none;
          opacity: 0.7;
          -webkit-transition: .2s;
          transition: opacity .2s;
        }

        .slider::-webkit-slider-thumb {
          -webkit-appearance: none;
          appearance: none;
          width: 25px;
          height: 25px;
          border-radius: 50%; 
          background: #f50505;
          cursor: pointer;
        }

        .slider::-moz-range-thumb {
          width: 25px;
          height: 25px;
          border-radius: 50%;
          background: #f50505;
          cursor: pointer;
        }
      </style>
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
        <div class="box box-danger" <?php echo $solo_lectura; ?>>
          <div class="box-header">
            <h3 class="box-title">Registrar Cotizaciones</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">*Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre de la Cotizacion">
                    <input type="hidden" id="id_cotizacion" name="id_cotizacion" value="0">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="llave_banorte">*Fecha Tentativa:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_cotizacion" name="fecha_cotizacion" >
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control"></select>
                  </div>
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <button type="button" id="btn_proveedores" class="btn btn-danger" href='#' data-id = '0' data-toggle = 'modal' data-target = '#modal-default2' target='blank' disabled><i class='fa fa-plus fa-lg'></i>  Proveedores</button>
            <button type="button" id="btn_conceptos" class="btn btn-primary" href='#' data-id = '1' data-toggle = 'modal' data-target = '#modal-default3' target='blank' disabled><i class='fa fa-plus fa-lg'></i>  Conceptos</button>
            <button type="button" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          </form>
        </div>
        <div class="box box-danger" style="display: none;" id="datos_cotizacion">
          <div class="box-header">
            <h3 class="box-title">Datos de la Cotización</h3>
          </div>
          <div class="box-body">
            <div id="datos"></div>
          </div>
        </div>
        <div class="box box-danger" id="tabla_c">
          <div class="box-header">
            <h3 class="box-title">Lista de Cotizaciones</h3>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_cotizaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th>Fecha</th>
                      <th>Sucursal</th>
                      <th>Proveedor Seleccionado</th>
                      <th width="5%">Eliminar</th>
                      <th>Ver</th>
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

  <?php include '../footer.php'; include'modal.php'; include'modal2.php'; include'modal3.php'; include'modal4.php';?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    function estilo_tablas() {
    $('#lista_cotizaciones').dataTable().fnDestroy();
    $('#lista_cotizaciones').DataTable( {
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
        "url": "tabla_cotizaciones.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Fecha" },
        { "data": "Sucursal" },
        { "data": "Proveedor" },
        { "data": "Eliminar" },
        { "data": "Ver" }
      ]
    });
  } 
  estilo_tablas();
    function cargar_tabla() {
      $('#lista_modulos').dataTable().fnDestroy();
      $('#lista_modulos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
            title: 'Modulos-Lista',
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
          "url": "tabla_modulos.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "id_modulo"
          },
          {
            "data": "nombre_modulo"
          },
          {
            "data": "desc_modulo"
          },
          {
            "data": "editar_modulo"
          }
        ]
      });
    }
    function cargar_tabla2() {
      var id_cotizacion = $('#id_cotizacion').val();
      $('#lista_conceptos').dataTable().fnDestroy();
      $('#lista_conceptos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
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
            title: 'Modulos-Lista',
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
          "url": "tabla_conceptos.php",
          "dataSrc": "",
          "data": {'id_cotizacion':id_cotizacion}
        },
        "columns": [{
            "data": "#",
            "width": "5%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Editar",
            "width": "5%"
          },
          {
            "data": "Eliminar",
            "width": "5%"
          }
        ]
      });
    }
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combos_sucursales.php",
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
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combo_proveedores.php",
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
    $('#guardar').click(function(){
      var url = "insertar_cotizacion.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          if (array[0] == "ok") {
            $('#nombre').attr('readonly',true);
            $('#id_cotizacion').val(array[1]);
            $('#btn_proveedores').removeAttr('disabled');
            $('#btn_conceptos').removeAttr('disabled');
            $('#guardar').attr('disabled',true);
            $('#datos_cotizacion').show();
            $('#tabla_c').hide();
            alertify.success("Registro guardado correctamente");
          } else if (array[0] == "duplicado") {
            alertify.error("El registro ya existe");
          }else if (array[0] == "ok2") {
            alertify.success("Registro guardado correctamente");
            $('#form_datos')[0].reset();
            $('#datos_cotizacion').hide();
            $('#tabla_c').show();
            $("#sucursal").select2("trigger", "select", {
              data: { id: '', text: '' }
            });
            $('#filtro').val('').trigger('change.select2');
            estilo_tablas();
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    })
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre: "required",
          fecha_cotizacion: "required",
          sucursal: "required"
        },
        messages: {
          nombre: "Campo requerido",
          fecha_cotizacion: "Campo requerido",
          sucursal: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          // Add the `help-block` class to the error element
          error.addClass("help-block");

          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
    });
    $('#modal-default').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
    });
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
      output.innerHTML = this.value;
    }
    $('#modal-default2').on('show.bs.modal', function(e) {
      // var id = $(e.relatedTarget).data().id;
      var id_cotizacion = $('#id_cotizacion').val();
      $('#id_cotizacion_proveedor').val(id_cotizacion);
      $('.tipo').removeClass('btn-danger');
      $('.tipo').addClass('btn-success');
      $('.tipo').html('Nuevo');
    });
    $('.tipo').click(function(){
      if($(this).hasClass('btn-success')){
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('INFOFIN');
        $('#nuevo').hide();
        $('#infofin').show();
        $('#tipo').val("2");
      }else{
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-success');
        $(this).html('Nuevo');
        $('#infofin').hide();
        $('#nuevo').show();
        $('#tipo').val("1");
      }
    })
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);

    $('#btn_guardar_proveedor').click(function(){
      var f = $(this);
      var formData = new FormData(document.getElementById("form_datos_proveedor"));
      formData.append("dato", "valor");
      var url = "insertar_proveedor.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            $('#nombre_proveedor').val("");
            $('#documento').val("");
            $('#id_cotizacion_proveedor').val("");
            $("#proveedor").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('.tipo').removeClass('btn-danger');
            $('.tipo').addClass('btn-success');
            $('.tipo').html('Nuevo');
            $('#form_datos_proveedor')[0].reset();
            $('#modal-default2').modal('hide');
            llenar_datos();
            $('#id_proveedor').val("0");
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else if(respuesta=="vacio"){
            alertify.error("Verifica Campos");
          }else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
        // Evitar ejecutar el submit del formulario.
      return false;
    })

    $('#modal-default3').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var id_cotizacion = $('#id_cotizacion').val();
      $('#id_cotizacion_conceptos').val(id_cotizacion);
      cargar_tabla2();
    }); 
    function editar_concepto(id){
      $.ajax({
        type: "POST",
        url: 'editar_concepto.php',
        data: {'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#concepto').val(respuesta);
          $('#id_concepto').val(id);
        }
      })
    }
    function llenar_datos(){
      var id_cotizacion = $('#id_cotizacion').val();
      var filtro        = $('#filtro').val();
      $.ajax({
        type: "POST",
        url: 'datos_cotizacion.php',
        data: {'id_cotizacion':id_cotizacion,'filtro':filtro}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#datos').html(respuesta);
        }
      })
    }
    function eliminar_concepto(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_concepto.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success("Registro Eliminado");
                cargar_tabla2();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
             }
          });
        } else {
          swal("No se ha eliminado el registro.",{
            icon: "error",
          });
        }
      });
    }
    $('#btn_guardar_concepto').click(function(){
      $.ajax({
        type: "POST",
        url: 'insertar_concepto.php',
        data: $("#form_datos_conceptos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            alertify.success("Registro Guardado");
            cargar_tabla2();
            $('#concepto').val("");
            $('#concepto').focus();
            llenar_datos();
          }else if(respuesta == "duplicado"){
            alertify.error("Registro Duplicado");
            $('#concepto').focus();
          }else{
            alertify.error("Ha Ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    })
    function eliminar_proveedor(id){
      swal({
        title: "¿Está seguro de eliminar el Proveedor?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_proveedor.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success("Registro Eliminado");
                llenar_datos();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
             }
          });
        } else {
          swal("No se ha eliminado el registro.",{
            icon: "error",
          });
        }
      });
    }
    function editar_proveedor(id){
      $('#modal-default2').modal('show');
      var url = "consulta_datos_proveedor.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);
          $('#id_proveedor').val(id);
          $('#tipo').val(array[0]);
          if(array[0] == 1){
            $('#nombre_proveedor').val(array[1]);
            $('.tipo').removeClass('btn-danger');
            $('.tipo').addClass('btn-success');
            $('.tipo').html('Nuevo');
            $('#nuevo').show();
            $('#infofin').hide();
            $('#tipo').val("1");
          }else{
            $("#proveedor").select2("trigger", "select", {
              data: { id: array[2], text:array[3] }
            });
            $('.tipo').removeClass('btn-success');
            $('.tipo').addClass('btn-danger');
            $('.tipo').html('INFOFIN');
            $('#nuevo').hide();
            $('#infofin').show();
            $('#tipo').val("2");
          }
          $('#fecha_entrega').val(array[4]);
          $('#plazo_dias').val(array[5]);
          $('#descuento').val(array[6]);
          $('#garantias').val(array[7]);
        }
      });
    }
    $('#modal-default4').on('show.bs.modal', function(e) {
      // var id = $(e.relatedTarget).data().id;
      // var id_cotizacion = $('#id_cotizacion').val();
      // $('#id_cotizacion_conceptos').val(id_cotizacion);
      // cargar_tabla2();
    });

    function guardar(numero,numero2,id_cotizacion){
      var id_proveedor = $('#proveedor_'+numero).val();
      var id_concepto  = $('#concepto_'+numero2).val();
      var costo        = $('#costo_'+numero+'_'+numero2).val();
      var calidad      = $('#boton_'+numero+'_'+numero2).html();

      //alert(numero+' '+numero2+' '+id_proveedor+' '+id_concepto+' '+costo+ ' '+calidad);

      if(costo == ""){
        alertify.error("Verifica Costo");
        return false;
      }
      if(calidad == "Calidad"){
        alertify.error("Selecciona Calidad");
        return false; 
      }

      $.ajax({
        type: "POST",
        url: 'guardar_costo_concepto.php',
        data: {'id_proveedor':id_proveedor,
                'id_concepto':id_concepto,
                'costo':costo,
                'calidad':calidad,
                'id_cotizacion':id_cotizacion
              }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          alertify.success("Registro Guardado");
          llenar_datos();
        }
      });
    }
    function seleccionar_proveedor(id_proveedor,id_cotizacion){
      $.ajax({
        type: "POST",
        url: 'seleccionar_proveedor.php',
        data: {'id_cotizacion':id_cotizacion,'id_proveedor':id_proveedor}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            alertify.success("Proveedor Seleccionado");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }
    function eliminar_cotizacion(id){
      swal({
        title: "¿Está seguro de eliminar la cotizacion?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            type: "POST",
            url: 'eliminar_cotizacion.php',
            data: {'id':id}, // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if(respuesta == "ok"){
                alertify.success("Cotizacion Eliminada");
                estilo_tablas();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        }
      });
    }
    function ver_cotizacion(id){
      $.ajax({
        type: "POST",
        url: 'consulta_cotizacion.php',
        data: {'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);

          $('#nombre').val(array[0]);
          $('#id_cotizacion').val(id);
          $('#fecha_cotizacion').val(array[1]);
          $("#sucursal").select2("trigger", "select", {
            data: { id: array[2], text:array[3] }
          });
          $('#btn_proveedores').removeAttr('disabled');
          $('#btn_conceptos').removeAttr('disabled');
          $('#guardar').attr('disabled',false);
          $('#datos_cotizacion').show();
          $('#tabla_c').hide();
          llenar_datos();
        }
      });
    }
    $('.combo').select2({
      placeholder: 'Selecciona una opcion'
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