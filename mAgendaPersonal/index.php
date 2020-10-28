<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
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
      <link rel="stylesheet" type="text/css" href="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.min.css">
      <link rel="stylesheet" type="text/css" href="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.print.css" media="print">
      <!-- <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print"> -->
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
      <section class="content-header">
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-body no-padding">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <br>
              <!-- /.box-body -->
              <?php
              $cadena = mysqli_query($conexion, "SELECT id_usuario,actual FROM vacaciones
                INNER JOIN usuarios ON usuarios.id = vacaciones.id_usuario WHERE id_usuario = '$id_usuario'");
              $cantidad = mysqli_num_rows($cadena);
              if ($cantidad != 0) {

                $row = mysqli_fetch_array($cadena);

                $cadena2 = mysqli_query($conexion, "SELECT fecha_vacaciones FROM historico_vacaciones WHERE id_usuario = '$id_usuario' AND activo = '1'");
                $cantidad_dias = 0;

                $row_vaca = mysqli_num_rows($cadena2);
                $cantidad_dias = $row_vaca;

                $cantidad_dias = ($cantidad_dias == "") ? 0 : $cantidad_dias;
                $resultado  = $row[1] - $cantidad_dias;
                $resultado2 = ($cantidad_dias * 100) / $row[1];
                ?>
                <div class="row">
                  <div class="col-md-12">
                    <label>Dias de Vacaciones Disponibles.</label>
                    <br>
                    <div class='col-md-3 col-sm-6 col-xs-12'>
                      <div class='info-box bg-yellow'>
                        <span class='info-box-icon'><i class='ion ion-person'></i></span>
                        <div class='info-box-content'>
                          <span class='info-box-text'><?php echo $nombre_persona; ?></span>
                          <span class='info-box-number'> <?php echo $resultado ?></span>
                          <div class='progress'>
                            <div class='progress-bar' style='width: <?php echo $resultado2; ?>%'></div>
                          </div>
                          <span class='progress-description'>
                            <?php echo $cantidad_dias; ?> dia(s) usados.
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Nuevo Evento</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="">*Nombre del Evento</label>
                        <input type="text" id='nombre_evento' name='nombre_evento' class='form-control'>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-primary">Guardar</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>
            <!-- /. box -->
          </div>
          <!-- /.col -->
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
  <script src="../d_plantilla/bower_components/moment/moment.js"></script>
  <script src="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="../d_plantilla/bower_components/jquery-ui/jquery-ui.min.js"></script>
  <script src="../d_plantilla/bower_components/fullcalendar/dist/locale-all.js"></script>
  <script>
    $(document).ready(function() {
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      var calendar = $('#calendar').fullCalendar({
        height: 'auto',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
          today: 'Hoy',
          month: 'Mes',
          week: 'Semana',
          day: 'Dia'
        },
        locale: 'es',
        editable: true,
        allDayDefault: true,
        events: 'recibir_eventos.php',
        // eventColor: '#f56954',
        selectable: true,
        selectHelper: true,
        // showNonCurrentDates: false,
        select: function(start, end, allDay) {
          alertify.prompt('Nuevo Evento', '',
            function(evt, title) {
              inicio = $.fullCalendar.formatDate(start, "YYYY-MM-DD hh:mm:ss");
              final = $.fullCalendar.formatDate(end, "YYYY-MM-DD hh:mm:ss");
              $.ajax({
                url: 'insertar_evento.php',
                data: 'title=' + title + '&start=' + inicio + '&end=' + final,
                type: "POST",
                success: function(json) {
                  if (json == "ok") {
                    alertify.success('Evento Añadido');
                    calendar.fullCalendar('removeEvents');
                    calendar.fullCalendar('refetchEvents');
                    llenar_notificaciones();
                  } else {
                    alertify.error('Ha Ocurrido un Error');
                  }
                }
              });
              calendar.fullCalendar('renderEvent', {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            },
            function() {
              calendar.fullCalendar('unselect');
            });
        },
        editable: true,
        eventDrop: function(event, delta) {
          inicio = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD hh:mm:ss");
          final = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD hh:mm:ss");
          $.ajax({
            url: 'actualizar_evento.php',
            data: 'title=' + event.title + '&start=' + inicio + '&end=' + final + '&id=' + event.id,
            type: "POST",
            success: function(json) {
              if (json == "ok") {
                alertify.success('Evento Actualizado');
                llenar_notificaciones();
              } else {
                alertify.error('Ha Ocurrido un Error');
              }
            }
          });
        },
        eventResize: function(event) {
          inicio = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD hh:mm:ss");
          final = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD hh:mm:ss");
          $.ajax({
            url: 'actualizar_evento.php',
            data: 'title=' + event.title + '&start=' + inicio + '&end=' + final + '&id=' + event.id,
            type: "POST",
            success: function(json) {
              if (json == "ok") {
                alertify.success('Evento Actualizado');
                llenar_notificaciones();
              } else {
                alertify.error('Ha Ocurrido un Error');
              }
            }
          });
        },
        eventRender: function(event, element) {
          element.click(function() {
            swal({
                title: "¿Está seguro de eliminar registro?",
                icon: "warning",
                buttons: ["No", "Si"],
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  $('#calendar').fullCalendar('removeEvents', event.id);
                  $.ajax({
                    url: 'eliminar_evento.php',
                    data: '&id=' + event.id,
                    type: "POST",
                    success: function(respuesta) {
                      if (respuesta == "ok") {
                        alertify.success('Evento Eliminado');
                        llenar_notificaciones();
                      } else {
                        alertify.error('Ha Ocurrido un Error');
                      }
                    }
                  });
                }
              });
          });
        }
      });
    });

    function limpiar_agenda() {
      $.ajax({
        url: 'quitar_eventos.php',
        data: {},
        type: "POST",
        success: function(respuesta) {
          alertify.success(respuesta + ' Registros Eliminados');
          location.reload();
        }
      });
    }
  </script>
</body>

</html>