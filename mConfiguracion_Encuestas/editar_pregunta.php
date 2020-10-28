<?php
  include '../global_seguridad/verificar_sesion.php';
  $id = $_GET['id'];
  $cadena = mysqli_query($conexion,"SELECT id,pregunta,id_departamento,tipo_pregunta,folio,id_categoria FROM preguntas WHERE id = '$id'");
  $row = mysqli_fetch_array($cadena);
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
            <h3 class="box-title">Editar Pregunta</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="pregunta">*Pregunta</label>
                  <input type="text" name="id" id="id" class="hidden" value="<?php echo $id;?>">
                  <input type="text" name="folio" id="folio" class="hidden" value="<?php echo $row[4];?>">
                  <input type="text" name="pregunta" id="pregunta" class="form-control" value="<?php echo $row[1];?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="departamento">*Departamento</label>
                  <select id="departamento" name="departamento[]" class="select2" multiple style="width: 100%"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="categoria">*Categoria</label>
                  <select id="categoria" name="categoria" class="select2" style="width: 100%">
                    <?php
                      $categoria = "";
                      if($row[5] == 1){
                        $categoria .= "<option value='1' selected>Frescura y Calidad</option>";
                        $categoria .= "<option value='2'>Orden y Acomodo de Mercancia</option>";
                        $categoria .= "<option value='3'>Atencion y Servicio al Cliente</option>";
                        $categoria .= "<option value='4'>Limpieza en Tiendas</option>";
                      }
                      else if ($row[5] == 2){
                        $categoria .= "<option value='1'>Frescura y Calidad</option>";
                        $categoria .= "<option value='2' selected>Orden y Acomodo de Mercancia</option>";
                        $categoria .= "<option value='3'>Atencion y Servicio al Cliente</option>";
                        $categoria .= "<option value='4'>Limpieza en Tiendas</option>"; 
                      }
                      else if ($row[5] == 3){
                        $categoria .= "<option value='1'>Frescura y Calidad</option>";
                        $categoria .= "<option value='2'>Orden y Acomodo de Mercancia</option>";
                        $categoria .= "<option value='3' selected>Atencion y Servicio al Cliente</option>";
                        $categoria .= "<option value='4'>Limpieza en Tiendas</option>"; 
                      }
                      else if ($row[5] == 4){
                        $categoria .= "<option value='1'>Frescura y Calidad</option>";
                        $categoria .= "<option value='2'>Orden y Acomodo de Mercancia</option>";
                        $categoria .= "<option value='3'>Atencion y Servicio al Cliente</option>";
                        $categoria .= "<option value='4' selected>Limpieza en Tiendas</option>"; 
                      }
                      else{
                        $categoria .= "<option value='' selected></option>";
                        $categoria .= "<option value='1'>Frescura y Calidad</option>";
                        $categoria .= "<option value='2'>Orden y Acomodo de Mercancia</option>";
                        $categoria .= "<option value='3'>Atencion y Servicio al Cliente</option>";
                        $categoria .= "<option value='4'>Limpieza en Tiendas</option>";  
                      }
                      echo $categoria;
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tipo_pregunta">*Tipo Pregunta</label>
                  <select id="tipo_pregunta" name="tipo_pregunta" class="select2" style="width: 100%">
                    <?php
                    $option = "";
                      if ($row[3] == 1){
                        $option .= "<option value='1' selected>Cuantitativo</option>";
                        $option .= "<option value='2'>Cualitativo</option>";
                        $option .= "<option value='3'>Libre</option>";
                        $option .= "<option value='4'>Cerrada</option>";
                        $option .= "<option value='5'>Cualitativo (Precios)</option>";
                      }
                      else if ($row[3] == 2){
                        $option .= "<option value='1'>Cuantitativo</option>";
                        $option .= "<option value='2' selected>Cualitativo</option>";
                        $option .= "<option value='3'>Libre</option>";
                        $option .= "<option value='4'>Cerrada</option>";
                        $option .= "<option value='5'>Cualitativo (Precios)</option>";
                      }
                      else if ($row[3] == 3){
                        $option .= "<option value='1'>Cuantitativo</option>";
                        $option .= "<option value='2'>Cualitativo</option>";
                        $option .= "<option value='3'selected>Libre</option>"; 
                        $option .= "<option value='4'>Cerrada</option>";
                        $option .= "<option value='5'>Cualitativo (Precios)</option>";
                      }
                      else if ($row[3] == 4){
                        $option .= "<option value='1'>Cuantitativo</option>";
                        $option .= "<option value='2'>Cualitativo</option>";
                        $option .= "<option value='3'>Libre</option>"; 
                        $option .= "<option value='4'selected>Cerrada</option>";
                        $option .= "<option value='5'>Cualitativo (Precios)</option>";
                      }
                      else if($row[3] == 5){
                        $option .= "<option value='1'>Cuantitativo</option>";
                        $option .= "<option value='2'>Cualitativo</option>";
                        $option .= "<option value='3'>Libre</option>"; 
                        $option .= "<option value='4'>Cerrada</option>";
                        $option .= "<option value='5'selected>Cualitativo (Precios)</option>";
                      }
                      echo $option;
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Actualizar</button>
            </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Preguntas Existentes</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="lista_preguntas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Pregunta</th>
                    <th>Departamento</th>
                    <th>Categoria</th>
                    <th>Tipo Pregunta</th>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function cargar_tabla_preguntas(){
    $('#lista_preguntas').dataTable().fnDestroy();
    $('#lista_preguntas').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_preguntas.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Pregunta" },
        { "data": "Departamento" },
        { "data": "Categoria" },
        { "data": "Tipo Pregunta" },
        { "data": "Editar" },
        { "data": "Eliminar" },
      ]
   });
  } 
  $(function (){
   cargar_tabla_preguntas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "actualizar_pregunta.php"; // El script a dónde se realizará la petición.
          $.ajax({
             type: "POST",
             url: url,
             data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
             success: function(respuesta)
             {
              if (respuesta=="ok") {
                location.href='index.php';
              }else if(respuesta=="Verifica"){
                alertify.error("Verifica Campos");
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
          pregunta: "required",
          departamento: "required",
          tipo_pregunta: "required",
        },
        messages: {
          pregunta: "Campo requerido",
          departamento: "Campo requerido",
          tipo_pregunta: "Campo requerido",
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
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
  function llenar_combo_departamentos(folio) {
    $.ajax({
      type: "POST",
      url: "combo_departamentos.php",
      data: "&folio="+folio,
      type:"POST",
      success: function(response)
      { 
        $('#departamento').html(response).fadeIn();
      }
    });
  }
  llenar_combo_departamentos(<?php echo $row[4]?>);
  function eliminar(id){
    swal({
        title: "¿Está seguro de eliminar pregunta?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        swal("La pregunta se ha eliminado.", {
          icon: "success",
        });
        $.ajax({
          url: 'eliminar_pregunta.php',
          data: '&id='+ id ,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              cargar_tabla_preguntas();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
           }
        });
      } else {
        swal("No se ha eliminado la pregunta.",{
          icon: "error",
        });
      }
    });
  }
</script>
</body>
</html>