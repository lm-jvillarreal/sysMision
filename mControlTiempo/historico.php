<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date('Y-m-d');
  $hora=date('h:i:s');
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Historico Control de Tiempos</h3>
            <!-- <a onclick="limpiar_hora()">Limpiar</a> -->
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <select id="usuarios" class="select2" style="width: 100%" onchange="cargar_tabla_datos(this.value)"></select>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <b><div id="nombre"></div></b>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_datos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="5%">Fecha</th>
                        <th width="12%">Hora Inicio</th>
                        <th width="10%">Hora Final</th>
                        <th width="5%">Tipo</th>
                        <th width="5%">Diferencia</th>
                        <th>Comentario</th>
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
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'modal_pagar.php'; ?>
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
function cargar_tabla_datos(id_persona) {
  $('#lista_datos').dataTable().fnDestroy();
  $('#lista_datos').DataTable( {
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
        "url": "tabla_datos.php",
        "dataSrc": "",
        "data":{'dato':id_persona}
    },
    "columns": [
        { "data": "#" },
        { "data": "Fecha" },
        { "data": "HoraI" },
        { "data": "HoraF" },
        { "data": "Tipo" },
        { "data": "Diferencia" },
        { "data": "Comentario" },
    ]
 });
}
</script>
<script>
  function activar_fecha(numero){
  if ($('#input_fecha'+numero).hasClass('hidden')){
    $('#input_fecha'+numero).removeClass('hidden');  
  }
  else{
    $('#input_fecha'+numero).addClass('hidden');
  }
}
function actualizar_fecha(fecha,id){
    $.ajax({
      url: 'actualizar_fecha.php',
      data: '&id='+ id+'&fecha='+ fecha,
      type: "POST",
      success: function(respuesta) {
        var array  = eval(respuesta);
        mensaje    = array[0];
        id_persona = array[1];

        if(mensaje == "ok"){
          alertify.success('Fecha Actualizada');
          cargar_tabla_datos(id_persona);
        }
        else if (mensaje == "igual"){}
        else{
          alert(mensaje);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function activar_horaini(numero){
    if ($('#input_horaini'+numero).hasClass('hidden')){
      $('#input_horaini'+numero).removeClass('hidden');  
    }
    else{
      $('#input_horaini'+numero).addClass('hidden');
    }
  }
  function actualizar_horaini(horaini,id){
    $.ajax({
      url: 'actualizar_horaini.php',
      data: '&id='+ id+'&horaini='+ horaini,
      type: "POST",
      success: function(respuesta) {
        var array  = eval(respuesta);
        mensaje    = array[0];
        id_persona = array[1];

        if(mensaje == "ok"){
          alertify.success('Hora Actualizada');
          cargar_tabla_datos(id_persona);
        }
        else if (mensaje == "igual"){}
        else if (mensaje = "verifica"){
          alertify.error('Verifica Hora');
        }
        else{
          alert(mensaje);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function activar_horafin(numero){
    if ($('#input_horafin'+numero).hasClass('hidden')){
      $('#input_horafin'+numero).removeClass('hidden');  
    }
    else{
      $('#input_horafin'+numero).addClass('hidden');
    }
  }
  function actualizar_horafin(horafin,id){
    $.ajax({
      url: 'actualizar_horafin.php',
      data: '&id='+ id+'&horafin='+ horafin,
      type: "POST",
      success: function(respuesta) {
        var array  = eval(respuesta);
        mensaje    = array[0];
        id_persona = array[1];

        if(mensaje == "ok"){
          alertify.success('Hora Actualizada');
          cargar_tabla_datos(id_persona);
        }
        else if (mensaje == "igual"){}
        else if (mensaje = "verifica"){
          alertify.error('Verifica Hora');
        }
        else{
          alert(mensaje);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  // $(function () {
  //   $('.select2').select2({
  //     placeholder: 'Seleccione una opcion',
  //     lenguage: 'es'
  //   })
  // })

  $(function () {
    $('#usuarios').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
   url: "combo_usuarios.php",
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
            
            $('#nom_persona').html(array[0]);
            $('#horas_disponibles').val(array[1]);
            $('#horas_disp').val(array[2]);
            $('#id_pers').val(array[3]);
          }
        });
    });
    function verificar_horas(horas_pagar){
      if(horas_pagar != ""){
        var horas_disponibles = $('#horas_disp').val();
        if(horas_pagar > horas_disponibles){
          $('#btn-pagar').attr('disabled', 'true');
          alertify.error("Verifica horas a pagar"); 
        }
        else{
          $('#btn-pagar').removeAttr('disabled');
        }
      }  
    }
    $("#btn-pagar").click(function(){
        var id_pers = $('#id_pers').val();
        var url = "pagar_nuevo.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form_datos_pagar').serialize(),
          success: function(respuesta) {
            if (respuesta=="ok") {
              alertify.success("Tiempo Pagado Correctamente");
              $('#modal-default').modal('hide');
              cargar_tabla_datos(id_pers);
              $('#h_pagar').val('');
            }else if(respuesta == "1"){
              alertify.error("Verifica Campos");
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
    });
    $('#h_pagar').inputmask('99:99');
</script>
</body>
</html>
