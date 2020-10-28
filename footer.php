<?php include '../mEncuestasDirigidas/modal.php';?>
<!-- jQuery 3 -->
<script src="../d_plantilla/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../d_plantilla/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="../d_plantilla/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../d_plantilla/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../d_plantilla/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../d_plantilla/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../d_plantilla/bower_components/moment/min/moment.min.js"></script>
<script src="../d_plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../d_plantilla/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../d_plantilla/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="../d_plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../d_plantilla/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="../d_plantilla/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../d_plantilla/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../d_plantilla/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../d_plantilla/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../d_plantilla/dist/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="../plugins/alertifyjs/alertify.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../plugins/jquery-validation-1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript" src="../plugins/bootstrap-filestyle/src/bootstrap-filestyle.js"></script>
<script type="text/javascript">
  function verificador_precios(){
    var ancho_ventana = 450;
    var alto_ventana = 768;
    var window_left = (screen.width - ancho_ventana - 12) / 2;
    var window_top = (screen.height - alto_ventana - 57) / 2;
    pop2 = window.open("../mVerificador/verificador_precios.php", "ventana", "width=" + ancho_ventana + ",height=" + alto_ventana + ",top=" + window_top + ",screenY=" + window_top + ",left=" + window_left + ",screenX=" + window_left + "");
    pop2.focus();
  }
  function verificador_inventario(){
    var ancho_ventana = 450;
    var alto_ventana = 768;
    var window_left = (screen.width - ancho_ventana - 12) / 2;
    var window_top = (screen.height - alto_ventana - 57) / 2;
    pop1 = window.open("../mVerificador/verificador_inventario.php", "ventana", "width=" + ancho_ventana + ",height=" + alto_ventana + ",top=" + window_top + ",screenY=" + window_top + ",left=" + window_left + ",screenX=" + window_left + "");
    pop1.focus();
  }
</script>
<script>
  function llenar_notificaciones(){
    $.ajax({
       url: '/sysMision/mAgendaPersonal/notificaciones.php',
       data: "",
       type: "POST",
       success: function(respuesta) {
         var array = eval(respuesta);
         cantidad  = array[0];
         mensaje   = array[1];
         cuerpo    = array[2];
         $('#cantidad_notificaciones').html(cantidad);
         $('#cantidad_notificaciones1').html(mensaje);
         $('#cuerpo').html(cuerpo);
       }
     });
  }
  llenar_notificaciones();
  $('#modal-default5').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data().id;
    var url = "../mEncuestasDirigidas/consulta_datos_encuesta.php"; // El script a dónde se realizará la petición.
    $.ajax({
      type: "POST",
      url: '../mEncuestasDirigidas/datos_encuesta.php',
      data: {id:id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        $('#n_encuesta_modal').html(respuesta);
      }
    });
    $.ajax({
      type: "POST",
      url: url,
      data: {id:id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        $('#encuesta_preguntas').html(respuesta);
      }
    });
  });
  function guardar_respuesta(){
    var url = "../mPanel_control/guardar_resp2.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-datos').serialize(),
        success: function(respuesta) {
          if(respuesta == "vacio"){
            alertify.error("Verifica Campos"); 
            
          }else{
            alertify.success("Respuesta Enviada Correctamente");
            $('#modal-default5').modal('hide');
            llenar_notificaciones();
          }
        }
      });
    return false;
  }
  $('#modulos').select2({
    placeholder: 'Buscar Módulo',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "../mPanel_control/combo_modulos.php",
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
  $('#modulos').change(function(){
    var modulo = this.value;
    $.ajax({
      url: '../consulta_modulo.php',
      type: "POST",
      dateType: "html",
      data: {'modulo':modulo},
      success: function(respuesta) {
        window.location.href = '../'+respuesta+'/';
      }
    });
  })
</script>
<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Manual de Usuario</b></h4>
      </div>
      <div class="modal-body">
        <p><?php echo $ayuda_modulo;?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <?php $ruta = ($manual == "") ? "#":"href='../mModulos/".$manual."' target='_blank'";?>
        <a <?php echo $ruta;?> class="btn btn-warning pull-right">Descargar Manual</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->