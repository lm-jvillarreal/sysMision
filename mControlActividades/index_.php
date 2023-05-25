<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
            <h3 class="box-title">Listado de actividades | Mantenimiento Correctivo</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="tabla_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>ID</th>
                        <th width='15'>Área</th>
                        <th width='10%'>Actividad</th>
                        <th>Descripción</th>
                        <th width='10%'>Sucursal</th>
                        <th width='15%'>Responsable</th>
                        <th width='10%'>Estatus</th>
                        <th width='10%'></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button id="btnInsertar" class="btn btn-success">Insertar</button>
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
    <?php include 'modal_tickets.php'; ?>
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
  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-database.js"></script>
  <!-- Page script -->
  <script type="text/javascript">
    $(document).ready(function() {
      const config = {
        //AQUÍ VA TU PORPIO SDK DE FIREBASE
        apiKey: "AIzaSyCdB6L5_Gs6Gq7lFCAgfa7mKyRgIUYh9y8",
        authDomain: "lmmovilmantenimiento.firebaseapp.com",
        databaseURL: "https://lmmovilmantenimiento-default-rtdb.firebaseio.com",
        projectId: "lmmovilmantenimiento",
        storageBucket: "lmmovilmantenimiento.appspot.com",
        messagingSenderId: "67904752071",
        appId: "1:67904752071:web:8bb566eb6fe122f01ff1e2",
        measurementId: "G-RKYPT1Y7C1"
      };
      firebase.initializeApp(config); //inicializamos firebase

      var filaEliminada; //para capturara la fila eliminada
      var filaEditada; //para capturara la fila editada o actualizada

      //creamos constantes para los iconos editar y borrar    
      const iconoEditar = '<svg class="bi bi-pencil-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>';
      const iconoBorrar = '<svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>';

      var db = firebase.database();
      var coleccionProductos = db.ref().child("Actividades");

      var dataSet = []; //array para guardar los valores de los campos inputs del form
      var table = $('#tabla_actividades').DataTable({
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
            title: 'Pasivos por documentar',
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
          },
        ],
        data: dataSet,
        columnDefs: [{
            targets: [0],
            visible: false, //ocultamos la columna de ID que es la [0]                        
          },
          {
            targets: -1,
            defaultContent: "<button class='btnEditar btn btn-primary' data-toggle='tooltip' title='Editar'>" + iconoEditar + "</button> <button class='btnBorrar btn btn-danger' data-toggle='tooltip' title='Borrar'>" + iconoBorrar + "</button>"
          }
        ]
      });

      coleccionProductos.on("child_added", datos => {
        dataSet = [datos.key, datos.child("area").val(), datos.child("tipo_actividad").val(), datos.child("descripcion").val(), datos.child("sucursal").val(), datos.child("nombre_responsable ").val(), datos.child("status").val()];
        table.rows.add([dataSet]).draw();
        alertify.success("Nuevo registro");
      });
      coleccionProductos.on('child_changed', datos => {
        dataSet = [datos.key, datos.child("area").val(), datos.child("tipo_actividad").val(), datos.child("descripcion").val(), datos.child("sucursal").val(), datos.child("nombre_responsable ").val(), datos.child("status").val()];
        table.row(filaEditada).data(dataSet).draw();
      });
      coleccionProductos.on("child_removed", function() {
        table.row(filaEliminada.parents('tr')).remove().draw();
      });
      $("#tabla_actividades").on("click", ".btnBorrar", function() {
        filaEliminada = $(this);
        Swal.fire({
          title: '¿Está seguro de eliminar la actividad?',
          text: "¡Está operación no se puede revertir!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Borrar'
        }).then((result) => {
          if (result.value) {
            let fila = $('#tabla_actividades').dataTable().fnGetData($(this).closest('tr'));
            let id = fila[0];
            db.ref(`Actividades/${id}`).remove()
            Swal.fire('¡Eliminado!', 'El producto ha sido eliminado.', 'success')
          }
        })
      });
    });

    function writeNewPost() {
      // A post entry.
      var postData = {
        area: "Panaderia",
        tipo_actividad: "Correctiva",
        descripcion: "Se dañó la toma de corriente",
        sucursal: "Arboledas",
        nombre_responsable: "El Jack",
        estatus: "en espera"
      };

      // Get a key for a new Post.
      var newPostKey = firebase.database().ref().child('Actividades').push().key;

      // Write the new post's data simultaneously in the posts list and the user's post list.
      var updates = {};
      updates['/Actividades/' + newPostKey] = postData;
      //updates['/user-posts/' + uid + '/' + newPostKey] = postData;

      return firebase.database().ref().update(updates);
    }
    $("#btnInsertar").click(function(){
      writeNewPost();
    })
  </script>
</body>

</html>