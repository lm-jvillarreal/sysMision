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
            <div id="t_registro"">
              <h3 class="box-title">Registro de Equipos | Escáner</h3>
            </div>
          </div>
          <div class="box-body">
            <div id="registro"">
              <form method="POST" id="form_datos">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="number" name="id_registro" id="id_registro" value="0" class="hidden">
                      <label for="marca">*Marca</label>
                      <select id="marca" class="form-control" name="marca">
                        <option></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="serie">*Serie</label>
                      <select id="serie" class="form-control" name="serie" style="width: 100%"></select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="numero_serie">*Número de Serie</label>
                      <input type="text" name="numero_serie" id="numero_serie" class="form-control" placeholder="Número de Serie" onchange="crear_cadena(this.value)">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="llave_banorte">*Llave Banorte</label>
                      <input type="text" name="llave_banorte" id="llave_banorte" class="form-control" placeholder="Llave Banorte" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="caja">*Caja</label>
                      <input type="text" name="caja" id="caja" class="form-control" placeholder="Caja">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="llave_banorte">*Sucursal</label>
                      <select id="sucursal" name="sucursal" class="form-control" style="width: 100%" onchange="usu_sucursal(this.value)">
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="tipo">*Tipo</label>
                      <input type="text" id="tipo" name="tipo" class="form-control" placeholder="Tipo" readonly>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="llave_banorte">*Afiliación</label>
                      <input type="text" id="afiliacion" name="afiliacion" class="form-control" placeholder="Afiliacion" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="usuario">*Usuario</label>
                      <input type="text" id="usuario_banorte" name="usuario_banorte" class="form-control"placeholder="Usuario" readonly>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contraseña">*Contraseña</label>
                      <input type="text" id="contraseña" name="contraseña" class="form-control" placeholder="Contraseña" readonly>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="tipo">*Cashback</label>
                      <select id="cashback" name="cashback" class="form-control" style="width: 100%"></select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="tipo">*Cifrada</label>
                      <select id="cifrada" name="cifrada" class="form-control" style="width: 100%"></select>
                    </div>
                  </div>
                </div>  
                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                </div>
              </form>
            </div>
            <div id="reporte" style="display: none;">
              <form method="POST" id="form_reporte">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="number" name="id_caja" id="id_caja" value="0" class="hidden">
                      <input type="number" name="id_reporte" id="id_reporte" value="0" class="hidden">
                      <label id="datos"></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="caja">*Número de Reporte</label>
                      <input type="text" name="num_reporte" id="num_reporte" class="form-control" placeholder="Número de Reporte">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="llave_banorte">*Fecha Estimada de Llegada</label>
                      <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_llegada" name="fecha_llegada" >
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="llave_banorte">*Falla</label>
                      <input type="text" id="falla" name="falla" class="form-control" placeholder="Falla">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="llave_banorte">*Número de Serie</label>
                      <input type="text" id="num_serie" name="num_serie" class="form-control" readonly>
                    </div>
                  </div>
                </div> 
                <div class="box-footer text-right">
                  <a class="btn btn-warning" onclick="guardar_reporte();" id="g_reporte">Guardar</a>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Equipos Existentes </h3>
            <div class="box-tools pull-right">
              <a onclick="estilo_tablas();">
                <i class="fa fa-refresh fa-spin"></i>
              </a>
            </div>
            <br>
            <div class="row">
              <div class="col-md-3 col-md-offset-9">
                <div class="form-group">
                  <select id="sucursal_2" name="sucursal" class="form-control" style="width: 100%" onchange="estilo_tablas()">
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_equipos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>N/S</th>
                        <th>Llave</th>
                        <th>Caja</th>
                        <th>Tienda</th>
                        <th>Afiliacion</th>
                        <th>Tipo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Reporte </th>
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
              <div class="col-md-12" id="tabla2" style="display: none;">
                <div class="table-responsive">
                  <table id="historial_equipo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th># Reporte</th>
                        <th>Fecha Llegada</th>
                        <th>Falla</th>
                        <th># Serie Nueva</th>
                        <th># Serie Anterior</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Actualizar</th>
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
  <?php include 'modal_act_terminal.php'; ?>
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
    var id_sucursal = $('#sucursal_2').val();
    $('#lista_equipos').dataTable().fnDestroy();
    $('#lista_equipos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_equipos.php",
        "dataSrc": "",
        "data" :{'id_sucursal':id_sucursal}
      },
      "columns": [
        { "data": "#" },
        { "data": "Marca" },
        { "data": "Modelo" },
        { "data": "NS" },
        { "data": "Llave" },
        { "data": "Caja" },
        { "data": "Tienda" },
        { "data": "Afiliacion" },
        { "data": "Tipo" },
        { "data": "Editar" },
        { "data": "Eliminar" },
        { "data": "Reporte Falla" },
      ]
    });
   }  
  $(function (){
   estilo_tablas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_terminal.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if (respuesta=="ok") {
                alertify.success("Registro guardado correctamente");
                limpiar();
                estilo_tablas();
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
          marca: "required",
          modelo: "required",
          numero_serie: "required",
          llave_banorte: "required",
          caja: "required",
          sucursal: "required",
          afiliacion: "required",
          usuario_banorte: "required",
          contraseña: "required",
          tipo: "required",
          cashback: "required",
          cifrada: "required"
        },
        messages: {
          marca: "Campo requerido",
          modelo: "Campo requerido",
          numero_serie: "Campo requerido",
          llave_banorte: "Campo requerido",
          caja: "Campo requerido",
          sucursal: "Campo requerido",
          afiliacion: "Campo requerido",
          usuario_banorte: "Campo requerido",
          contraseña: "Campo requerido",
          tipo: "Campo requerido",
          cashback: "Campo requerido",
          cifrada: "Campo requerido"
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
  </script>
  <script>
    function estilo_tablas2() {
    var id_caja = $('#id_caja').val();
    $('#historial_equipo').dataTable().fnDestroy();
    $('#historial_equipo').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_historial.php",
        "dataSrc": "",
        "data" :{'id_caja':id_caja}
      },
      "columns": [
        { "data": "#" },
        { "data": "# Reporte" },
        { "data": "Fecha Llegada" },
        { "data": "Falla" },
        { "data": "SN" },
        { "data": "SA" },
        { "data": "Editar" },
        { "data": "Eliminar" },
        { "data": "Actualizar" },
      ]
    });
   }
    function cargar_cashback(cashback){
      var opciones,texto;
      for (var i = 1; i <= 2; i++) {
        if(i == 1){
          texto = "Si";
        }
        else{
          texto = "No";
        }
        if (texto == cashback){
          opciones += "<option value='" + texto + "' selected>" + texto + "</option>";  
        }
        else{
          opciones += "<option value='" + texto + "'>" + texto + "</option>";
        }
      }
      $('#cashback').html(opciones).fadeIn();
    }
    function cargar_cifrada(cifrada){
      var opciones,texto;
      for (var i = 1; i <= 2; i++) {
        if(i == 1){
          texto = "Si";
        }
        else{
          texto = "No";
        }
        if (texto == cifrada){
          opciones += "<option value='" + texto + "' selected>" + texto + "</option>";  
        }
        else{
          opciones += "<option value='" + texto + "'>" + texto + "</option>";
        }
      }
      $('#cifrada').html(opciones).fadeIn();
    }
    cargar_cashback();
    cargar_cifrada();
    function volver(){
      $('#sucursal').attr('onchange',"usu_sucursal(this.value)");
      $('#modelo').attr('onchange',"llenar_datos(this.value)");
    }
    function editar_registro(id){
      $.ajax({
        url: 'editar_registro.php',
        data: '&id='+ id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          id_marca      = array[0];
          marca         = array[1];
          id_modelo     = array[2];
          modelo        = array[3];
          numero_serie  = array[4];
          llave_banorte = array[5];
          caja          = array[6];
          id_sucursal   = array[7];
          sucursal      = array[8];
          afiliacion    = array[9];
          usuario       = array[10];
          contrasena    = array[11];
          tipo          = array[12];
          cashback      = array[13];
          cifrada       = array[14];

          $('#id_registro').val(id);

          $('#sucursal').removeAttr('onchange');
          $('#modelo').removeAttr('onchange');

          $("#marca").select2("trigger", "select", {
            data: { id: id_marca, text:marca }
          });

          $("#modelo").select2("trigger", "select", {
            data: { id: id_modelo, text:modelo }
          });

          $("#sucursal").select2("trigger", "select", {
            data: { id: id_sucursal, text:sucursal }
          });

          $('#numero_serie').val(numero_serie);
          $('#llave_banorte').val(llave_banorte);
          $('#caja').val(caja);
          $('#afiliacion').val(afiliacion);
          $('#usuario_banorte').val(usuario);
          $('#contraseña').val(contrasena);
          $('#tipo').val(tipo);
          if (tipo == "PINPAD"){
            $('#usuario_banorte').removeAttr('readonly');
            $('#contraseña').removeAttr('readonly');
          }else if(tipo == "DUAL-UP"){
            $('#usuario_banorte').attr('readonly', true);
            $('#contraseña').attr('readonly', true);
            $('#afiliacion').removeAttr('readonly');
          }else if(tipo == "GRPS"){
            $('#usuario_banorte').attr('readonly', true);
            $('#contraseña').attr('readonly', true);
            $('#afiliacion').removeAttr('readonly');
          }
          cargar_cashback(cashback);
          cargar_cifrada(cifrada);
          volver();
        }
      });
    }
    function eliminar(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_equipo.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                estilo_tablas();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
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
    function eliminar_reporte(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_reporte.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                estilo_tablas2();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
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
    function limpiar(){
      $("#marca").select2("trigger", "select", {
        data: { id: '', text:'' }
      });
      $("#modelo").select2("trigger", "select", {
        data: { id: '', text:'' }
      });
      $("#sucursal").select2("trigger", "select", {
        data: { id: '', text:'' }
      });
      cargar_cashback();
      cargar_cifrada();
      $(':text').val("");
    }
    function usu_sucursal(sucursal){
      $.ajax({
        url: 'mostrar_usuario.php',
        data: '&sucursal='+ sucursal,
        type: "POST",
        success: function(respuesta) {
          array = eval(respuesta);
          usuario   = array[0];
          pass      = array[1];
          num_afili = array[2];

          $('#usuario_banorte').val(usuario);
          $('#contraseña').val(pass);
          $('#afiliacion').val(num_afili);
         }
      });
    }
    function llenar_datos(modelo){
      $.ajax({
        url: 'datos2.php',
        data: '&modelo='+ modelo,
        type: "POST",
        success: function(respuesta) {
          array = eval(respuesta);
          tipo   = array[0];

          $('#tipo').val(tipo);

          if (tipo == "PINPAD"){
            $('#usuario_banorte').removeAttr('readonly');
            $('#contraseña').removeAttr('readonly');
          }else if(tipo == "DUAL-UP"){
            $('#usuario_banorte').attr('readonly', true);
            $('#contraseña').attr('readonly', true);
            $('#afiliacion').removeAttr('readonly');
          }else if(tipo == "GRPS"){
            $('#usuario_banorte').attr('readonly', true);
            $('#contraseña').attr('readonly', true);
            $('#afiliacion').removeAttr('readonly');
          }
         }
      });
    }
    function crear_cadena(cadena){
      cadena_nueva = cadena.replace(/['-]+/g, '');
      $('#llave_banorte').val(cadena_nueva);
    }
    function reporte(id){
      $('#boton_regresar').show();

      $('#t_registro').hide();
      $('#t_reporte').show();

      $('#registro').hide();
      $('#reporte').show();    

      $('#tabla').hide();
      $('#tabla2').show();

      $.ajax({
        url: 'datos.php',
        type: "POST",
        data:{'id':id},
        success: function(respuesta) {
          var array = eval(respuesta);

          $('#datos').html(array[0]);
          $('#num_serie').val(array[1]);
          $('#id_caja').val(id);
          estilo_tablas2();
        }
      });
    }
    function regresar(){
      $('#boton_regresar').hide();

      $('#t_registro').show();
      $('#t_reporte').hide();

      $('#registro').show();
      $('#reporte').hide(); 

      $('#tabla').show();
      $('#tabla2').hide();

      $('#num_reporte').val("");
      $('#falla').val("");
      $('#num_serie').val("");

    }
    function guardar_reporte() {
      $.ajax({
        type: "POST",
        url: 'guardar_reporte.php',
        data: $("#form_reporte").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Reporte guardado correctamente");
            estilo_tablas2();
            $('#id_reporte').val("0");
            // $('#num_reporte').val("");
            $('#falla').val("");
            $('#num_serie').val("");
          }else if(respuesta == "1"){
            alertify.error("Numero de serie no existe");
          }else{
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    }
    function editar_reporte(id){
      $.ajax({
        url: 'editar_reporte.php',
        data: '&id='+ id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          num_reporte = array[0];
          fecha       = array[1];
          falla       = array[2];
          num_serie   = array[3];
          id_e        = array[4];

          $('#id_reporte').val(id);

          $('#num_reporte').val(num_reporte);
          $('#fecha_llegada').val(fecha);
          $('#falla').val(falla);
          $('#num_serie').val(num_serie);
        }
      });
    }
    $('#modal-default').on('show.bs.modal', function(e) {
       var id = $(e.relatedTarget).data().id;
       var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {id:id}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            var array = eval(respuesta);
            
            $('#d_caja').val(array[0]);
            $("#marca_m").select2("trigger", "select", {
              data: { id: array[1], text:array[2] }
            });
            $("#modelo_m").select2("trigger", "select", {
              data: { id: array[3], text:array[4] }
            });
            $('#numero_serie_m').val(array[5]);
            $('#id_historico').val(array[6]);
            $('#n_reporte').html(array[7]);
          }
        });
    });
    $("#btn-actualizar").click(function(){
      var url = "actualizar_terminal.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-datos-act').serialize(),
          success: function(respuesta) {
            if (respuesta=="ok") {
            alertify.success("Caja Actualizada Correctamente");
            $('#modal-default').modal('hide');
            estilo_tablas2();
            estilo_tablas();
            }else if(respuesta == "1"){
              alertify.error("Verifica Numero de Serie");
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
        return false;
    });
  </script>
  <script>
    $(function () {
      $('#marca').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
         url: "combos_marcas.php",
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
    $(function () {
      $('#marca_m').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
       url: "combos_marcas.php",
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
    $(function () {
      $('#modelo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
       url: "combo_modelos.php",
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
    $(function () {
      $('#modelo_m').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
       url: "combo_modelos.php",
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
    $(function () {
      $('#sucursal').select2({
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
    $(function () {
      $('#sucursal_2').select2({
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
    $(function () {
      $('#cashback').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
    });
    $(function () {
      $('#cifrada').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
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