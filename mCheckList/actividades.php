<?php
  include '../global_seguridad/verificar_sesion.php';

  $tiempo_completo = $fecha.' '.$hora;
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
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <div class="box-header">
            <h3 class="box-title">Registro de Actividades para el Check-List</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="hidden" name="id_registro" id="id_registro" value="0">
                    <label for="nombre_modulo">*Check-List</label>
                    <select name="checklist" id="checklist" class="form-control" onchange="cargar()"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_modulo">*Actividad</label>
                    <input type="text" name="actividad" id="actividad" class="form-control" placeholder="Nombre de Actividad">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_carpeta">*Sub-Departamento</label>
                    <select name="sub_departamento" id="sub_departamento" class="form-control"></select>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Actividades</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Sub-Departamento</th>
                        <th>Frecuencia</th>
                        <th>Duracion</th>
                        <th>Programar</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody></tbody>  
                    <tfoot>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Sub-Departamento</th>
                      <th>Frecuencia</th>
                      <th>Duracion</th>
                      <th>Programar</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
   <?php include '../footer2.php'; include 'modal3.php'; include 'modal4.php';?>
    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <?php include '../footer.php'; include 'modal.php'; include 'modal2.php';?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $(function(){
      $('#checklist').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
          url: "combo_checklist.php",
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
    })
    $(function(){
      $('#sub_departamento').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
       url: "combo_subdepartamentos.php",
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
    })
  </script>
  <script>
    function cargar(){
      cargar_tabla();
      if($('#menu_programacion_multiple').hasClass('hidden')){
        $('#menu_programacion_multiple').removeClass('hidden');
      }
    }
    function cargar_tabla() {
      var checklist = $('#checklist').val();
      $('#lista_actividades').dataTable().fnDestroy();
      $('#lista_actividades thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
      });
      var table = $('#lista_actividades').DataTable( {
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
              title: 'Control Tiempo',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Control Tiempo',
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
          "url": "tabla_actividades.php",
          "dataSrc": "",
          "data":{'checklist':checklist}
        },
        "columns": [
          { "data": "#","width": "5%" },
          { "data": "Nombre" },
          { "data": "SubDepartamento" },
          { "data": "Frecuencia", "width": "10%" },
          { "data": "Duracion", "width": "10%" },
          { "data": "Programar", "width": "5%" },
          { "data": "Editar", "width": "5%" },
          { "data": "Eliminar", "width": "5%" },
        ]
      });
      table.columns().every( function () {
        var that = this;
        $( 'input', this.header() ).on( 'keyup change', function () {
          if ( that.search() !== this.value ) {
            that
              .search( this.value )
              .draw();
          }
        });
      });
    }
    function cargar_tabla2() {
      $('#lista_sub_departamentos').dataTable().fnDestroy();
      $('#lista_sub_departamentos').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
          "paging":   true,
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
              title: 'Control Tiempo',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Control Tiempo',
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
          "url": "tabla_subd.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#" , "width": "5%"},
          { "data": "Nombre" },
          { "data": "Editar" , "width": "5%"},
          { "data": "Eliminar" , "width": "5%"},
        ]
      });
    }  
    $(function (){
     cargar_tabla();
    })
    $.validator.setDefaults( {
      submitHandler: function () {
        $.ajax({
          type: "POST",
          url: 'guardar_actividad.php',
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            if (respuesta=="ok") {
              alertify.success("Registro Guardado Correctamente");
              cargar_tabla();
              $('#form_datos')[0].reset();
              $("#sub_departamento").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
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
          checklist: "required",
          actividad: "required",
          sub_departamento: "required"
        },
        messages: {
          checklist: "Campo requerido",
          actividad: "Campo requerido",
          sub_departamento: "Campo requerido"
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
    $(function () {
      $('#datetimepicker_inicio').datetimepicker();
      $('#datetimepicker_fin').datetimepicker();
      $('.form_date').datetimepicker({
        language: 'es',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
      });
    });
    function editar(id){
      $.ajax({
        type: "POST",
        url: 'editar_actividad.php',
        data:{'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);

          $('#id_registro').val(id);
          $('#actividad').val(array[0]);
          $("#sub_departamento").select2("trigger", "select", {
            data: { id: array[1], text:array[2] }
          });
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
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
            type: "POST",
            url: 'eliminar_actividad.php',
            data:{'id':id}, // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              cargar_tabla();
              alertify.success("Registro Eliminado Correctamente");
            }
          });
          // Evitar ejecutar el submit del formulario.
          return false;
        }
      });
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);
          $('#nombre_actividad_modal').html(array[0]);
          $('#id_actividad').val(id); 
          limpiar();
          if(array[1] == 0){
            $('#boton_cambiar').addClass('btn-danger');
            $('#icono_boton').addClass('fa-ban');
            $('#texto_cambiar').html('No Repetir');
          }
        }
      });
    });
    $('#modal-default2').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var url = "consulta_datos2.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array1            = eval(respuesta);
          var dias_selecionados = "";

          $('#id_actividad_modal').val(id);
          $('#nombre_check').html(array1[0]);
          $('#nombre_actividad').html(array1[1]);
          $('#nombre_subdepartamento').html(array1[2]);
          $('#fecha_inicio_modal').html(array1[3]);
          if(array1[5] == 1){
            $('#afecha_final').hide();
            $('#t_programacion').html('Repetir');
            $('#arepite').show();
            $('#duracion_act').show();
            $('#finaliza_act').show();
            $('#se_repite').html(array1[6]);
            $('#duracion_actividad').html(array1[14]);
            if(array1[6] == "Cada Semana"){
              $('#dias_selec').show();
              dias_selecionados += (array1[7] != null)?"Domingo,":"";
              dias_selecionados += (array1[8] != null)?"Lunes,":"";
              dias_selecionados += (array1[9] != null)?"Martes,":"";
              dias_selecionados += (array1[10] != null)?"Miercoles,":"";
              dias_selecionados += (array1[11] != null)?"Jueves,":"";
              dias_selecionados += (array1[12] != null)?"Viernes,":"";
              dias_selecionados += (array1[13] != null)?"Sabado,":"";
              var nueva_dias = dias_selecionados.slice(0, -1);
              $('#dias_seleccionados').html(nueva_dias);
            }
            if(array1[15] == 0){
              $('#finaliza_modal').html('Nunca');
            }else{
              $('#finaliza_modal').html(array1[16]);
            }
          }else{
            $('#dias_selec').hide();
            $('#arepite').hide();
            $('#afecha_final').show();
            $('#duracion_act').hide();
            $('#finaliza_act').hide();
            $('#fecha_final_modal').html(array1[4])
            $('#t_programacion').html('Unica');
          }
        }
      });
    });
    function cambiar(){
      if($('#boton_cambiar').hasClass('btn-danger')){
        //////////////////////Botones////////////////
        $('#boton_cambiar').removeClass('btn-danger');
        $('#boton_cambiar').addClass('btn-success');
        $('#texto_cambiar').html('Repetir');
        $('#icono_boton').removeClass('fa-ban');
        $('#icono_boton').addClass('fa-check');
        //////////////////////Botones////////////////
        $('#fecha_final').hide();
        $('#repetir').val("1");
        $('#otro').show();
      }else{
        //////////////////////Botones////////////////
        $('#boton_cambiar').remove('btn-success');
        $('#boton_cambiar').addClass('btn-danger');
        $('#icono_boton').removeClass('fa-check');
        $('#icono_boton').addClass('fa-ban');
        $('#texto_cambiar').html('No Repetir');
        //////////////////////Botones////////////////
        $('#fecha_final').show();
        $('#repetir').val("0");
        $('#finaliza').val("0");
        $('#otro').hide();
      }
    }
    ///////Creamos el Array para almacenar los dias
    var array = [];
    $(".dias").click(function(){
      var valor  = $(this).val();
      ///////Verificamos si existe
      if(array.includes(valor)){
        ///////Obetenemos la ubicacion del elemento
        var pos = array.indexOf(valor);
        ///////Eliminamos el elemento
        array.splice(pos, 1);
      }else{
        ///////Añadimos el elemento
        array.push(valor);
      }
      $('#dias_selecionados').val(array);
      console.log(array);
      
      if($(this).hasClass('btn-success')){
        $(this).removeClass('btn-success');
        $(this).addClass('btn-default');
      }else{
        $(this).addClass('btn-success');
      }
    });
    $('#repite').change(function(){
      var repite = $(this).val();
      if(repite == 2){
        $('#dias').show();
      }else{
        $('#dias').hide();
      }
    });
    $('#boton_finaliza').click(function(){
      if($(this).hasClass('btn-danger')){
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-primary');
        $('#texto_finaliza').html('El');
        $('#finaliza').val("1");
        $('#icono_finaliza').addClass('fa-calendar-o');
        $('#fecha_finaliza').show();
      }else{
        $(this).addClass('btn-danger');
        $('#texto_finaliza').html('Nunca');
        $('#finaliza').val("0");
        $('#icono_finaliza').removeClass('fa-calendar-o');
        $('#icono_finaliza').addClass('fa-ban');
        $('#fecha_finaliza').hide();
      }
    });
    $('.combo2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
    function addZero(i) {
      if (i < 10) {
        i = '0' + i;
      }
      return i;
    }
    function hoyFecha(){
      var hoy = new Date();
      var dd = hoy.getDate();
      var mm = hoy.getMonth()+1;
      var yyyy = hoy.getFullYear();
      
      dd = addZero(dd);
      mm = addZero(mm);

      return yyyy+'-'+mm+'-'+dd;
    }
    function limpiar(){
      ////////Limpiar el repetir /////
      $('#boton_cambiar').remove('btn-success');
      $('#boton_cambiar').addClass('btn-danger');
      $('#icono_boton').removeClass('fa-check');
      $('#icono_boton').addClass('fa-ban');
      $('#texto_cambiar').html('No Repetir');
      $('#repetir').val("0");
      $('#fecha_final').show();
      $('#otro').hide();

      var fecha = hoyFecha();
      $('#fecha_inicio').val(fecha);
      $('#fecha_fin').val(fecha);
      ////////Limpiar el repetir /////

      //Limpiar los combos//
      $('#repite').val('1').trigger('change.select2');
      $('#duracion').val('1').trigger('change.select2');
      //Limpiar los combos//

      //Limpiar los dias //
      $('.dias').removeClass('btn-success');
      $('.dias').addClass('btn-default');
      $('#dias').hide();
      $('#dias_selecionados').val("");
      array.length = 0;
      //Limpiar los dias //

      //Limpiar Finaliza//
      $('#boton_finaliza').addClass('btn-danger');
      $('#texto_finaliza').html('Nunca');
      $('#finaliza').val("0");
      $('#icono_finaliza').removeClass('fa-calendar-o');
      $('#icono_finaliza').addClass('fa-ban');
      $('#fecha_finaliza').hide();
      $('#fecha_final2').val(fecha);
      //Limpiar Finaliza//
    }
    $('#programar').click(function(){
      $.ajax({
        type: "POST",
        url: 'programar_actividad.php',
        data: $('#form_datos_modal').serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == 1){
            alertify.error("Fechas Iguales, Verifica Fechas");
          }else if(respuesta == 2){
            alertify.error("Falta Hora, Verifica Fechas");
          }else if(respuesta == 3){
            alertify.error("Error en Fechas, Verifica Fechas");
          }else if(respuesta == 4){
            alertify.error("Falta Dias, Selecciona Dias");
          }else if(respuesta == 5){
            alertify.error("Error en Fecha de Finalizacion, Verifica Fecha");
          }else if(respuesta == "ok"){
            alertify.success("Actividad programada correctamente");
            $('#modal-default').modal('hide');
            cargar_tabla();
          }
        }
      });
    });
    $('#eliminar_programacion').click(function(){
      var id_actividad = $('#id_actividad_modal').val();
      swal({
        title: "¿Está seguro de eliminar la programacion?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            type: "POST",
            url: 'eliminar_programacion.php',
            data:{'id_actividad':id_actividad}, // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if(respuesta == "ok"){
                cargar_tabla();
                $('#modal-default2').modal('hide');
                alertify.success("Programacion Eliminada Correctamente");
              }else{
                alertify.success("Ha Ocurrido un Error");
              }
            }
          });
          // Evitar ejecutar el submit del formulario.
          return false;
        }
      });
    });
    $('#modal-default3').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      cargar_tabla2();
    });
    function eliminar_sd(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            type: "POST",
            url: 'eliminar_sd.php',
            data:{'id':id}, // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              alertify.success("Registro Eliminado Correctamente");
              cargar_tabla2();
            }
          });
          // Evitar ejecutar el submit del formulario.
          return false;
        }
      });
    }
    function editar_sd(id){
      $.ajax({
        type: "POST",
        url: 'editar_sd.php',
        data:{'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);
          $('#id_sub_departamento_modal').val(id);
          $('#sub_departamento_modal').val(array[0]);
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
    $('#guardar_sub').click(function(){
      var sub_departamento    = $('#sub_departamento_modal').val();
      var id_sub_departamento = $('#id_sub_departamento_modal').val();
      $.ajax({
        type: "POST",
        url: 'guardar_sub.php',
        data: {'sub_departamento':sub_departamento,'id_sub_departamento':id_sub_departamento}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro Guardado Correctamente");
            cargar_tabla2();
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    })
    $('#modal-default4').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var id_checklist = $('#checklist').val();
      alertify.success(id_checklist);
      $('#id_check_list_modal').val(id_checklist);
      $("#actividad_predeterminada").select2("trigger", "select", {
        data: { id: '', text:'' }
      });
      $("#actividades").val('').trigger('change');
      $('#div2').hide();
      $('.tipo').removeClass('btn-danger');
      $('.tipo').addClass('btn-success');
      $('.tipo').html('Todas');
      $('#tipo').val('1');
    });
    $(function(){
      $('#actividad_predeterminada').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
          url: "combo_actividades.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var id_checklist = $('#id_check_list_modal').val();
            return {
              searchTerm: params.term, // search term
              id_checklist:id_checklist
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
      $('#actividades').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        allowClear: true,
        //minimumResultsForSearch: Infinity
        ajax: { 
          url: "combo_actividades2.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var id_checklist      = $('#id_check_list_modal').val();
            return {
              searchTerm: params.term, // search term
              id_checklist:id_checklist
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
    })
    $('.tipo').click(function(){
      $("#actividades").val('').trigger('change');
      if($(this).hasClass('btn-success')){
        $('#div2').show();
        $(this).removeClass('btn-success');
        $(this).addClass('btn-primary');
        $(this).html('Solo:');
        $('#tipo').val('2');
      }else if ($(this).hasClass('btn-primary')){
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-danger');
        $(this).html('Todas, Excepto:');
        $('#tipo').val('3');
      }else{
        $('#div2').hide();
        $(this).removeClass('btn-danger');
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-success');
        $(this).html('Todas');
        $('#tipo').val('1');
      }
    });
    $('#guardar_prog').click(function(){
      $.ajax({
        type: "POST",
        url: 'guardar_programacion2.php',
        data: $("#form_datos2").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            $('#modal-default4').modal('hide');
            alertify.success("Registro Guardado Correctamente");
            cargar_tabla();
            $('#form_datos2')[0].reset();
            $("#sub_departamento").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
          }else if(respuesta=="vacio"){
            alertify.error("Selecciona Activdades");
          }else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    })
  </script>
</body>
</html>
