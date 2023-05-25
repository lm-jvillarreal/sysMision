<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css" />
  <!--Select2-->
  <link rel="stylesheet" href="../d_plantilla/bower_components/select2/dist/css/select2.min.css">
  <!--dateTimePicker-->
  <link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" type="text/css" href="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.min.css">
      <link rel="stylesheet" type="text/css" href="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.print.css" media="print">
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
          <div class="box-body no-padding">
            <div id="calendar"></div>
            
            <div class="modal fade" id="modalM" tabindex="-1" role="basic" aria-hidden="true" style="display: none">
              <div class="modal-dialog" style="width:50%">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h4 class="modal-title">Asignar preventivo</h4>

                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-xs-12">
                                  <div class="form-group form-md-line-input">
                                  <label>*Tarea:</label>
                                  <input id="ipTarea" type="text" class="form-control" disabled>
                                  <br>
                                  <label>*Asignar a:</label>
                                  <br/>
                                  <select id="selectPersonas" class="form-control">
                                  </select>
                                  <br/>
                                  <label>*Equipo:</label>
                                  <br/>
                                  <input id="ipEquipo" type="text" class="form-control" disabled/>
                                  <br/>
                                  <label>*Área:</label>
                                  <input id="ipArea" type="text" class="form-control" disabled>
                                  <br/>
                                  <label>*Fecha de programación:</label>
                                  <input id="ipFecha" type="text" class="form-control" disabled>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <input type="hidden" id="modalId" />
                              <button type="button" id="btnCancelar" class="btn btn-danger cancelar">cancelar</button>
                              <button type="button" id="btnGuardar" class="btn btn-success guardar">Abrir</button>
                          </div>
                      </div>
                      <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
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
    <?php include 'modal_tickets.php';?>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <script src="../d_plantilla/bower_components/moment/moment.js"></script>
  <script src="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="../d_plantilla/bower_components/jquery-ui/jquery-ui.min.js"></script>
  <script src="../d_plantilla/bower_components/fullcalendar/dist/locale-all.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-database.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

  
  <!--script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  
  Date time para seleccionar los controladores de fecha--
  <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

  <script src="../d_plantilla/bower_components/select2/dist/js/select2.full.min.js"></script>
   timepicker--
  <script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="../plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
   The core Firebase JS SDK is always required and must be listed first -->

  <!-- Page script -->
  <script>
    $(document).ready(function(){
        const firebaseConfig = {
        apiKey: "AIzaSyB84ezoeyNnP0DZN3whC9VugNPt-ygEsJw",
        authDomain: "testkt-14d1d.firebaseapp.com",
        databaseURL: "https://testkt-14d1d-default-rtdb.firebaseio.com",
        projectId: "testkt-14d1d",
        storageBucket: "testkt-14d1d.appspot.com",
        messagingSenderId: "656134815579",
        appId: "1:656134815579:web:4e859d0f4630c1ad19e47e",
        measurementId: "G-XEVYNZ4MP7"
        };

        firebase.initializeApp(firebaseConfig);

        var db = firebase.database();
        var coleccionProductos = db.ref("pruebas6");

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var calendar = $('#calendar').fullCalendar({
            header: 'auto',
            header:{
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText:{
                today:'Hoy',
                month:'Mes',
                week: 'Semana',
                day: 'Día'
            },
            locale: 'es',
            editalbe: true,
            allDayDefault: true,
            events:'',
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay){
              //console.log("clickeado");
            },
            editable: true,
            eventDrop: function(event, delta){
                inicio = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD hh:mm:ss");
                final = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD hh:mm:ss");
                //se puede agregar un archivo/función para actualizar los eventos
            },
            eventResize: function(event){
                inicio = $.fullCalendar.formatDate(event.start,
                "YYYY-MM-DD hh:mm:ss");
                final = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD hh:mm:ss");
                //se puede agregar un archivo/función para actulizar los eventos
            },
            eventRender: function(event, element){
            },
            events: function(start, end, timezone, callback) {
              var events = [];
              coleccionProductos.on('value', (data) => {
                data.forEach(function(childS){
                  events.push({
                    id: childS.key,
                    daysOfWeek:['30'],
                    title: childS.val().descripcion,
                    start: childS.val().fecha,
                    end: childS.val().fecha,
                    responsable: childS.val().uAlta,
                    tipo: childS.val().tipo,
                    area: childS.val().area
                  });
                });
                callback(events);
              });
            },
            eventClick: function(event, jsEvent, view) {
              var validar = "";
              $('#ipTarea').val(event.title)
              $('#respo').html(event.responsable);
              $('#modalId').val(event.id);
              $('#modalM').modal();
              $('#ipEquipo').val(event.tipo);
              $('#ipArea').val(event.area);
              $('#ipFecha').val(event.start._i);
              db.ref("pruebas").on('value', (data) => {
                data.forEach(function(childS){
                  $('#selectPersonas').append($("<option />").text(childS.key));
                });
              });
              db.ref("tareas").on('value', (data)=>{
                  data.forEach(function(childS){
                    if (childS.val().idTarea === event.id) {
                      validar = "validado"
                    }
                  });
                });
              $('.cancelar').click(function(events){
               // var id = $('')
                $('#selectPersonas').find('option').remove();
                $('#modalM').modal('hide');
              });
              $('#btnGuardar').one("click",function(events){

                const hoy = new Date();
                const fecha = hoy.toISOString();
                const primerDia = new Date(hoy.setDate(hoy.getDate() - hoy.getDay() + 1));
                const finalDia = new Date(hoy.setDate(hoy.getDate() - hoy.getDay() + 7));
                const primerDiaReal = primerDia.toISOString();
                const finalDiaReal = finalDia.toISOString();

                console.log(primerDiaReal);
                console.log(finalDiaReal);
                if (fecha < primerDiaReal) {
                  console.log("anterior");
                } else {
                  if (fecha == primerDiaReal) {
                    console.log("hoy"); 
                  } else {
                    console.log("posterior");
                  }
                }
                //console.log(primerDia);
                //console.log(finalDia);
                /*if (validar === "validado") {
                  alert("Ya existe este registro");
                } 
                else {
                  var id = $('#modalId').val();
                  var evento = $('#calendar').fullCalendar('clientEvents', id);
                  evento[0].backgroundColor = 'green';
                  //console.log(events);
                  $('#calendar').fullCalendar('addEventSource', events);

                  var tarea = $('#ipTarea').val();
                  var responsable = $('#selectPersonas').val();
                  var equipo = $('#ipEquipo').val();
                  var area = $('#ipArea').val()
                  var fecha = $('#ipFecha').val();

                  var mes = m + 1;
                  var result = (mes.toString().length <= 1) ? 
                  ("0"+mes.toString()) :
                  (mes.toString());
                  
                  db.ref("tareas").push().set({
                    idTarea: id,
                    tarea: tarea,
                    repsonsable: responsable,
                    equipo: equipo,
                    area: area,
                    fecha: y + "-" + mes + "-" + d,
                    status: "en proceso",
                    programado: fecha
                  });

                  $('#selectPersonas').find('option').remove();
                  $('#modalM').modal('hide');
                  /*db.ref("tareas").push().set({
                    pruebas: "hola",
                    pruebas2: "mundo"
                  });*/ 
                //}
              });
            }
        });
    });
  </script>
</body>
</html>